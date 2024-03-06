<?php

namespace Nullform\AppStoreServerApiClient;

use Firebase\JWT\JWT;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use Nullform\AppStoreServerApiClient\Exceptions\AppleException;
use Nullform\AppStoreServerApiClient\Exceptions\HttpClientException;
use Nullform\AppStoreServerApiClient\Models\JWSTransactionDecodedPayload;
use Nullform\AppStoreServerApiClient\Models\Requests\ConsumptionRequest;
use Nullform\AppStoreServerApiClient\Models\Requests\ExtendRenewalDateRequest;
use Nullform\AppStoreServerApiClient\Models\Responses\ExtendRenewalDateResponse;
use Nullform\AppStoreServerApiClient\Models\Responses\HistoryResponse;
use Nullform\AppStoreServerApiClient\Models\Responses\OrderLookupResponse;
use Nullform\AppStoreServerApiClient\Models\Responses\RefundLookupResponse;
use Nullform\AppStoreServerApiClient\Models\Responses\StatusResponse;
use Nullform\HttpStatus;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\Uid\Uuid;

/**
 * PHP client for App Store Server API.
 *
 * Create an API Key instance:
 *
 * ```
 * $apiKey = new class extends AbstractApiKey {};
 * $apiKey->setPrivateKey(\file_get_contents($privateKeyFile));
 * $apiKey->setPrivateKeyId('Your private key id');
 * $apiKey->setIssuerId('Your issuer id');
 * $apiKey->setName('Name (optional)');
 * ```
 *
 * Create a Bundle instance(s):
 *
 * ```
 * $bundle = new class extends AbstractBundle {};
 * $bundle->setBundleId('Your bundle id');
 * $bundle->setName('Name (optional)');
 * $bundle2 = new class extends AbstractBundle {};
 * $bundle2->setBundleId('Your bundle #2 id');
 * ```
 *
 * Create an API client instance:
 *
 * ```
 * $client = new AppStoreServerApiClient($apiKey, $bundle, Environment::PRODUCTION);
 * try {
 *     $historyResponse = $client->getTransactionHistory($originalTransactionId);
 * } catch (HttpClientException $httpClientException) {
 *     echo "HTTP client error: " . $httpClientException->getMessage();
 * } catch (AppleException $appleException) {
 *     echo "Apple error ({$appleException->getCode()}): " . $appleException->getMessage();
 * }
 *
 * try {
 *     $bundle2HistoryResponse = $client->setBundle($bundle2)->getTransactionHistory($originalTransactionId);
 * } catch (\Exception $e) {
 *     echo "Error: " . $e->getMessage();
 * }
 * ```
 *
 *
 * @link https://developer.apple.com/documentation/appstoreserverapi
 */
class AppStoreServerApiClient
{
    /**
     * @var Environment
     */
    protected $environment;

    /**
     * @var ApiKeyInterface
     */
    protected $apiKey;

    /**
     * @var BundleInterface
     */
    protected $bundle;

    /**
     * @var int
     */
    protected $tokenTtl = 3600;

    /**
     * @var float
     */
    protected $httpClientRequestTimeout = 5.0;

    /**
     * @var null|HttpClient
     */
    protected $httpClient = null;

    /**
     * @param ApiKeyInterface $apiKey
     * @param BundleInterface $bundle
     * @param string $environment sandbox or production
     * @see Environment::SANDBOX
     * @see Environment::PRODUCTION
     */
    public function __construct(ApiKeyInterface $apiKey, BundleInterface $bundle, string $environment)
    {
        $this->environment = new Environment($environment);
        $this->apiKey = $apiKey;
        $this->setBundle($bundle);
    }

    /**
     * Set App Store bundle for authorize your API calls.
     *
     * @param BundleInterface $bundle
     * @return $this
     */
    public function setBundle(BundleInterface $bundle): self
    {
        $this->bundle = $bundle;

        return $this;
    }

    /**
     * Set new value for JWT TTL (in seconds).
     *
     * @param int $ttl
     * @return $this
     * @link https://developer.apple.com/documentation/appstoreserverapi/generating_tokens_for_api_requests
     */
    public function setTokenTtl(int $ttl): self
    {
        $this->tokenTtl = $ttl;

        return $this;
    }

    /**
     * Set new value for HTTP client request timeout.
     *
     * @param float $timeout
     * @return $this
     */
    public function setHttpClientRequestTimeout(float $timeout): self
    {
        $this->httpClientRequestTimeout = $timeout;

        return $this;
    }

    /**
     * Get a customer’s in-app purchase transaction history for your app.
     *
     * @param string $originalTransactionId
     * @param string|null $revision
     * @return HistoryResponse
     * @throws AppleException
     * @throws HttpClientException
     * @link https://developer.apple.com/documentation/appstoreserverapi/get_transaction_history
     */
    public function getTransactionHistory(string $originalTransactionId, ?string $revision = null): HistoryResponse
    {
        $path = "inApps/v1/history/{$originalTransactionId}";
        if ($revision) {
            $path .= "?revision={$revision}";
        }

        $response = $this->callApi("GET", $path);
        $contents = $response->getBody()->getContents();

        return new HistoryResponse($contents);
    }

    /**
     * Recursively get FULL transaction history.
     *
     * @param string $originalTransactionId
     * @return JWSTransactionDecodedPayload[]
     * @throws AppleException
     * @throws HttpClientException
     * @uses AppStoreServerApiClient::getTransactionHistory()
     */
    public function getAllTransactionHistory(string $originalTransactionId): array
    {
        $revision = null;
        $transactions = [];

        $getTransactions = function () use ($originalTransactionId, &$revision, &$transactions, &$getTransactions) {
            $response = $this->getTransactionHistory($originalTransactionId, $revision);
            $revision = $response->revision;
            $transactions = \array_merge($transactions, $response->getDecodedTransactions());
            if ($response->hasMore) {
                $getTransactions();
            }
        };

        $getTransactions();

        return $transactions;
    }

    /**
     * Get the statuses for all of a customer’s subscriptions in your app.
     *
     * @param string $originalTransactionId
     * @return StatusResponse
     * @throws AppleException
     * @throws HttpClientException
     * @link https://developer.apple.com/documentation/appstoreserverapi/get_all_subscription_statuses
     */
    public function getAllSubscriptionStatuses(string $originalTransactionId): StatusResponse
    {
        $response = $this->callApi("GET", "inApps/v1/subscriptions/{$originalTransactionId}");
        $contents = $response->getBody()->getContents();

        return new StatusResponse($contents);
    }

    /**
     * Send consumption information about a consumable in-app purchase to the App Store after your server receives
     * a consumption request notification.
     *
     * @param string $originalTransactionId
     * @param ConsumptionRequest $request
     * @return void
     * @throws AppleException
     * @throws HttpClientException
     * @link https://developer.apple.com/documentation/appstoreserverapi/send_consumption_information
     */
    public function sendConsumptionInformation(string $originalTransactionId, ConsumptionRequest $request): void
    {
        $this->callApi("PUT", "inApps/v1/transactions/consumption/{$originalTransactionId}", $request);
    }

    /**
     * Get a customer’s in-app purchases from a receipt using the order ID.
     *
     * @param string $orderId
     * @return OrderLookupResponse
     * @throws AppleException
     * @throws HttpClientException
     * @link https://developer.apple.com/documentation/appstoreserverapi/look_up_order_id
     */
    public function lookUpOrderId(string $orderId): OrderLookupResponse
    {
        $response = $this->callApi("GET", "inApps/v1/lookup/{$orderId}");
        $contents = $response->getBody()->getContents();

        return new OrderLookupResponse($contents);
    }

    /**
     * Get a list of all refunded in-app purchases in your app for a customer.
     *
     * @param string $originalTransactionId
     * @return RefundLookupResponse
     * @throws AppleException
     * @throws HttpClientException
     * @link https://developer.apple.com/documentation/appstoreserverapi/get_refund_history
     */
    public function getRefundHistory(string $originalTransactionId): RefundLookupResponse
    {
        $response = $this->callApi("GET", "inApps/v1/refund/lookup/{$originalTransactionId}");
        $contents = $response->getBody()->getContents();

        return new RefundLookupResponse($contents);
    }

    /**
     * Extend the renewal date of a customer’s active subscription using the original transaction identifier.
     *
     * @param string $originalTransactionId
     * @param ExtendRenewalDateRequest $request
     * @return ExtendRenewalDateResponse
     * @throws AppleException
     * @throws HttpClientException
     * @link https://developer.apple.com/documentation/appstoreserverapi/extend_a_subscription_renewal_date
     */
    public function extendSubscriptionRenewalDate(
        string $originalTransactionId,
        ExtendRenewalDateRequest $request
    ): ExtendRenewalDateResponse {
        $response = $this->callApi("PUT", "inApps/v1/subscriptions/extend/{$originalTransactionId}", $request);
        $contents = $response->getBody()->getContents();

        return new ExtendRenewalDateResponse($contents);
    }

    /**
     * Get HTTP Client instance.
     *
     * @param array $options
     * @return HttpClient
     */
    protected function httpClient(array $options = []): HttpClient
    {
        return $this->httpClient = new HttpClient(
            \array_merge([
                'base_uri'                      => $this->environment->getBaseUrl(),
                RequestOptions::TIMEOUT         => $this->httpClientRequestTimeout,
                RequestOptions::ALLOW_REDIRECTS => true,
                RequestOptions::HTTP_ERRORS     => false,
                RequestOptions::HEADERS         => [
                    'Authorization' => "Bearer {$this->jwt()}"
                ],
            ], $options)
        );
    }

    /**
     * Call App Store Server API.
     *
     * @param string $method
     * @param string $path Relative path.
     * @param AbstractModel|null $body
     * @return ResponseInterface
     * @throws HttpClientException
     * @throws AppleException
     */
    protected function callApi(string $method, string $path, ?AbstractModel $body = null): ResponseInterface
    {
        $clientExtraOptions = [];

        if ($body) {
            $clientExtraOptions[RequestOptions::JSON] = $body->toJson();
        }

        try {
            $response = $this->httpClient($clientExtraOptions)->request($method, $path);
            $status = $response->getStatusCode();
        } catch (GuzzleException $exception) {
            throw new HttpClientException($exception->getMessage(), $exception->getCode(), $exception);
        }

        if (!HttpStatus::isSuccessful($status)) {
            throw AppleException::fromResponse($response);
        }

        return $response;
    }

    /**
     * New JWT for API calls.
     *
     * @return string
     * @link https://developer.apple.com/documentation/appstoreserverapi/generating_tokens_for_api_requests
     */
    protected function jwt(): string
    {
        $payload = [
            'iss'   => $this->apiKey->getIssuerId(),
            'iat'   => time() - 10,
            'exp'   => time() + $this->tokenTtl - 10,
            // "v1" regardless of the version in the URI. See "Create the JWT payload" doc.
            // For example, if we set "aud" as "v2" for request "/inApps/v2/refund/lookup/{transactionId}",
            // we get 401 Unauthorized.
            'aud'   => "appstoreconnect-v1",
            'nonce' => Uuid::v4(),
            'bid'   => $this->bundle->getBundleId(),
        ];

        return JWT::encode($payload, $this->apiKey->getPrivateKey(), 'ES256', $this->apiKey->getPrivateKeyId());
    }
}
