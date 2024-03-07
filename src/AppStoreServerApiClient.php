<?php

namespace Nullform\AppStoreServerApiClient;

use Firebase\JWT\JWT;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Uri;
use GuzzleHttp\RequestOptions;
use Nullform\AppStoreServerApiClient\Exceptions\AppleException;
use Nullform\AppStoreServerApiClient\Exceptions\HttpClientException;
use Nullform\AppStoreServerApiClient\Models\JWSTransactionDecodedPayload;
use Nullform\AppStoreServerApiClient\Models\Params\GetRefundHistoryParams;
use Nullform\AppStoreServerApiClient\Models\Params\GetTransactionHistoryParams;
use Nullform\AppStoreServerApiClient\Models\Requests\ConsumptionRequest;
use Nullform\AppStoreServerApiClient\Models\Requests\ExtendRenewalDateRequest;
use Nullform\AppStoreServerApiClient\Models\Requests\MassExtendRenewalDateRequest;
use Nullform\AppStoreServerApiClient\Models\Requests\NotificationHistoryRequest;
use Nullform\AppStoreServerApiClient\Models\Responses\CheckTestNotificationResponse;
use Nullform\AppStoreServerApiClient\Models\Responses\ExtendRenewalDateResponse;
use Nullform\AppStoreServerApiClient\Models\Responses\HistoryResponse;
use Nullform\AppStoreServerApiClient\Models\Responses\MassExtendRenewalDateResponse;
use Nullform\AppStoreServerApiClient\Models\Responses\MassExtendRenewalDateStatusResponse;
use Nullform\AppStoreServerApiClient\Models\Responses\NotificationHistoryResponse;
use Nullform\AppStoreServerApiClient\Models\Responses\OrderLookupResponse;
use Nullform\AppStoreServerApiClient\Models\Responses\RefundHistoryResponse;
use Nullform\AppStoreServerApiClient\Models\Responses\SendTestNotificationResponse;
use Nullform\AppStoreServerApiClient\Models\Responses\StatusResponse;
use Nullform\AppStoreServerApiClient\Models\Responses\TransactionInfoResponse;
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
     * @param string $transactionId The identifier of a transaction that belongs to the customer,
     *                              and which may be an original transaction identifier (originalTransactionId).
     * @param string|GetTransactionHistoryParams|null $paramsOrRevision Query parameters.
     *                                                                  If you don't need other parameters, you can pass
     *                                                                  only "revision" here.
     * @return HistoryResponse
     * @throws AppleException
     * @throws HttpClientException
     * @link https://developer.apple.com/documentation/appstoreserverapi/get_transaction_history
     */
    public function getTransactionHistory(string $transactionId, $paramsOrRevision = null): HistoryResponse
    {
        $params = \is_object($paramsOrRevision) && \is_a($paramsOrRevision, GetTransactionHistoryParams::class)
            ? $paramsOrRevision
            : new GetTransactionHistoryParams();

        if (!\is_object($paramsOrRevision) && $paramsOrRevision) {
            $params->revision = (string)$paramsOrRevision;
        }

        $response = $this->callApi("GET", "inApps/v1/history/{$transactionId}", $params);
        $contents = $response->getBody()->getContents();

        return new HistoryResponse($contents);
    }

    /**
     * Recursively get FULL transaction history.
     *
     * @param string $transactionId The identifier of a transaction that belongs to the customer,
     *                              and which may be an original transaction identifier (originalTransactionId).
     * @return JWSTransactionDecodedPayload[]
     * @throws AppleException
     * @throws HttpClientException
     * @uses AppStoreServerApiClient::getTransactionHistory()
     */
    public function getAllTransactionHistory(string $transactionId): array
    {
        $revision = null;
        $transactions = [];

        $getTransactions = function () use ($transactionId, &$revision, &$transactions, &$getTransactions) {
            $response = $this->getTransactionHistory($transactionId, $revision);
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
     * Get information about a single transaction for your app.
     *
     * @param string $transactionId The identifier of a transaction that belongs to the customer,
     *                              and which may be an original transaction identifier (originalTransactionId).
     * @return TransactionInfoResponse
     * @throws AppleException
     * @throws HttpClientException
     * @link https://developer.apple.com/documentation/appstoreserverapi/get_transaction_info
     */
    public function getTransactionInfo(string $transactionId): TransactionInfoResponse
    {
        $response = $this->callApi("GET", "inApps/v1/transactions/{$transactionId}");
        $contents = $response->getBody()->getContents();

        return new TransactionInfoResponse($contents);
    }

    /**
     * Get the statuses for all of a customer’s subscriptions in your app.
     *
     * @param string $transactionId The identifier of a transaction that belongs to the customer,
     *                              and which may be an original transaction identifier (originalTransactionId).
     * @return StatusResponse
     * @throws AppleException
     * @throws HttpClientException
     * @link https://developer.apple.com/documentation/appstoreserverapi/get_all_subscription_statuses
     */
    public function getAllSubscriptionStatuses(string $transactionId): StatusResponse
    {
        $response = $this->callApi("GET", "inApps/v1/subscriptions/{$transactionId}");
        $contents = $response->getBody()->getContents();

        return new StatusResponse($contents);
    }

    /**
     * Send consumption information about a consumable in-app purchase to the App Store after your server receives
     * a consumption request notification.
     *
     * @param string $transactionId The transaction identifier for which you’re providing consumption information.
     *                              You receive this identifier in the CONSUMPTION_REQUEST notification
     *                              the App Store sends to your server’s App Store Server Notifications V2 endpoint.
     * @param ConsumptionRequest $request
     * @return void
     * @throws AppleException
     * @throws HttpClientException
     * @link https://developer.apple.com/documentation/appstoreserverapi/send_consumption_information
     * @see NotificationV2Types::CONSUMPTION_REQUEST
     */
    public function sendConsumptionInformation(string $transactionId, ConsumptionRequest $request): void
    {
        $this->callApi("PUT", "inApps/v1/transactions/consumption/{$transactionId}", null, $request);
    }

    /**
     * Get a customer’s in-app purchases from a receipt using the order ID.
     *
     * Not available in the sandbox environment.
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
     * Get a paginated list of all of a customer’s refunded in-app purchases for your app.
     *
     * @param string $transactionId The identifier of a transaction that belongs to the customer,
     *                              and which may be an original transaction identifier (originalTransactionId).
     * @param string|GetRefundHistoryParams|null $paramsOrRevision Query parameters.
     *                                                             If you don't need other parameters, you can pass
     *                                                             only "revision" here.
     * @return RefundHistoryResponse
     * @throws AppleException
     * @throws HttpClientException
     * @link https://developer.apple.com/documentation/appstoreserverapi/get_refund_history
     */
    public function getRefundHistory(string $transactionId, $paramsOrRevision = null): RefundHistoryResponse
    {
        $params = \is_object($paramsOrRevision) && \is_a($paramsOrRevision, GetRefundHistoryParams::class)
            ? $paramsOrRevision
            : new GetRefundHistoryParams();

        if (!\is_object($paramsOrRevision) && $paramsOrRevision) {
            $params->revision = (string)$paramsOrRevision;
        }

        // V1 is deprecated. Using v2...
        $response = $this->callApi("GET", "inApps/v2/refund/lookup/{$transactionId}", $params);

        $contents = $response->getBody()->getContents();

        return new RefundHistoryResponse($contents);
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
        $response = $this->callApi("PUT", "inApps/v1/subscriptions/extend/{$originalTransactionId}", null, $request);
        $contents = $response->getBody()->getContents();

        return new ExtendRenewalDateResponse($contents);
    }

    /**
     * Uses a subscription’s product identifier to extend the renewal date for all of its eligible active subscribers.
     *
     * @param MassExtendRenewalDateRequest $request
     * @return MassExtendRenewalDateResponse
     * @throws AppleException
     * @throws HttpClientException
     * @link https://developer.apple.com/documentation/appstoreserverapi/extend_subscription_renewal_dates_for_all_active_subscribers
     */
    public function extendSubscriptionRenewalDatesForAllActiveSubscribers(
        MassExtendRenewalDateRequest $request
    ): MassExtendRenewalDateResponse {
        $response = $this->callApi("POST", "inApps/v1/subscriptions/extend/mass/", null, $request);
        $contents = $response->getBody()->getContents();

        return new MassExtendRenewalDateResponse($contents);
    }

    /**
     * Checks whether a renewal date extension request completed, and provides the final count of successful or
     * failed extensions.
     *
     * @param string $productId
     * @param string $requestIdentifier
     * @return MassExtendRenewalDateStatusResponse
     * @throws AppleException
     * @throws HttpClientException
     * @link https://developer.apple.com/documentation/appstoreserverapi/get_status_of_subscription_renewal_date_extensions
     */
    public function getStatusOfSubscriptionRenewalDateExtensions(
        string $productId,
        string $requestIdentifier
    ): MassExtendRenewalDateStatusResponse {
        $response = $this->callApi("GET", "inApps/v1/subscriptions/extend/mass/{$productId}/{$requestIdentifier}");
        $contents = $response->getBody()->getContents();

        return new MassExtendRenewalDateStatusResponse($contents);
    }

    /**
     * Ask App Store Server Notifications to send a test notification to your server.
     *
     * @return SendTestNotificationResponse
     * @throws AppleException
     * @throws HttpClientException
     * @link https://developer.apple.com/documentation/appstoreserverapi/request_a_test_notification
     */
    public function requestTestNotification(): SendTestNotificationResponse
    {
        $response = $this->callApi("POST", "inApps/v1/notifications/test");
        $contents = $response->getBody()->getContents();

        return new SendTestNotificationResponse($contents);
    }

    /**
     * Check the status of the test App Store server notification sent to your server.
     *
     * @param string $testNotificationToken
     * @return CheckTestNotificationResponse
     * @throws AppleException
     * @throws HttpClientException
     * @link https://developer.apple.com/documentation/appstoreserverapi/get_test_notification_status
     */
    public function getTestNotificationStatus(string $testNotificationToken): CheckTestNotificationResponse
    {
        $response = $this->callApi("GET", "inApps/v1/notifications/test/{$testNotificationToken}");
        $contents = $response->getBody()->getContents();

        return new CheckTestNotificationResponse($contents);
    }

    /**
     * Get a list of notifications that the App Store server attempted to send to your server.
     *
     * @param NotificationHistoryRequest $params
     * @param string|null $paginationToken
     * @return NotificationHistoryResponse
     * @throws AppleException
     * @throws HttpClientException
     * @link https://developer.apple.com/documentation/appstoreserverapi/get_notification_history
     */
    public function getNotificationHistory(
        NotificationHistoryRequest $params,
        ?string $paginationToken = null
    ): NotificationHistoryResponse {
        $queryParams = null;
        if ($paginationToken) {
            $queryParams = new class extends AbstractModel {
                public $paginationToken = '';
            };
            $queryParams->paginationToken = $paginationToken;
        }
        $response = $this->callApi("POST", "inApps/v1/notifications/history", $queryParams, $params);
        $contents = $response->getBody()->getContents();

        return new NotificationHistoryResponse($contents);
    }

    /**
     * Custom call App Store Server API.
     *
     * Get transaction history example:
     * ```
     * $response = $client->callApi("GET", "inApps/v1/history/$transactionId");
     * ```
     *
     * Request a test notification example:
     * ```
     * $response = $client->callApi("POST", "inApps/v1/notifications/test");
     * ```
     *
     * @param string $method GET, HEAD, POST, PUT, DELETE or PATCH.
     * @param string $path Relative path, eg: inApps/v2/refund/lookup/1234567890
     * @param AbstractModel|null $params Query parameters as an instance of AbstractModel.
     * @param AbstractModel|null $body HTTP body as an instance of AbstractModel.
     * @return ResponseInterface
     * @throws AppleException
     * @throws HttpClientException
     */
    public function callApi(
        string $method,
        string $path,
        ?AbstractModel $params = null,
        ?AbstractModel $body = null
    ): ResponseInterface {
        $method = trim($method);
        $path = trim($path);
        $path = (new Uri($path))->getPath();
        if (!\in_array(\strtolower($method), ['get', 'head', 'post', 'put', 'delete', 'patch'])) {
            throw new HttpClientException('Bad method');
        }
        if (!\preg_match('/^inApps\//', $path)) {
            throw new HttpClientException('Bad path');
        }

        $clientExtraOptions = [];

        if (!empty($params)) {
            $clientExtraOptions[RequestOptions::QUERY] = $params->toAppleQueryString();
        }
        if ($body) {
            $clientExtraOptions[RequestOptions::JSON] = $body->toArray();
        }

        try {
            $response = $this->getHttpClient($clientExtraOptions)->request($method, $path);
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
     * Get HTTP Client instance.
     *
     * @param array $options
     * @return HttpClient
     * @see RequestOptions
     */
    protected function getHttpClient(array $options = []): HttpClient
    {
        return $this->httpClient = new HttpClient(
            \array_merge([
                'base_uri'                      => $this->environment->getBaseUrl(),
                RequestOptions::TIMEOUT         => $this->httpClientRequestTimeout,
                RequestOptions::ALLOW_REDIRECTS => true,
                RequestOptions::HTTP_ERRORS     => false,
                RequestOptions::HEADERS         => [
                    'Authorization' => "Bearer {$this->getJwt()}"
                ],
            ], $options)
        );
    }

    /**
     * New JWT for API calls.
     *
     * @return string
     * @link https://developer.apple.com/documentation/appstoreserverapi/generating_tokens_for_api_requests
     */
    protected function getJwt(): string
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
