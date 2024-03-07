<?php

namespace Nullform\AppStoreServerApiClient\Tests;

use Nullform\AppStoreServerApiClient\Exceptions\AppleException;
use Nullform\AppStoreServerApiClient\Models\JWSRenewalInfoDecodedPayload;
use Nullform\AppStoreServerApiClient\Models\JWSTransactionDecodedPayload;
use Nullform\AppStoreServerApiClient\Models\LastTransactionsItem;
use Nullform\AppStoreServerApiClient\Models\NotificationHistoryResponseItem;
use Nullform\AppStoreServerApiClient\Models\NotificationsResponseBodyV2DecodedPayload;
use Nullform\AppStoreServerApiClient\Models\NotificationsResponseBodyV2DecodedPayloadData;
use Nullform\AppStoreServerApiClient\Models\NotificationsResponseBodyV2DecodedPayloadExternalPurchaseToken;
use Nullform\AppStoreServerApiClient\Models\NotificationsResponseBodyV2DecodedPayloadSummary;
use Nullform\AppStoreServerApiClient\Models\Params\GetTransactionHistoryParams;
use Nullform\AppStoreServerApiClient\Models\Requests\ExtendRenewalDateRequest;
use Nullform\AppStoreServerApiClient\Models\Requests\MassExtendRenewalDateRequest;
use Nullform\AppStoreServerApiClient\Models\Requests\NotificationHistoryRequest;
use Nullform\AppStoreServerApiClient\Models\Responses\HistoryResponse;
use Nullform\AppStoreServerApiClient\Models\Responses\MassExtendRenewalDateStatusResponse;
use Nullform\AppStoreServerApiClient\Models\Responses\StatusResponse;
use Nullform\AppStoreServerApiClient\Models\SubscriptionGroupIdentifierItem;
use Nullform\HttpStatus;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\Uid\Uuid;

class AppStoreServerApiClientTest extends AbstractTestCase
{
    public function testGetTransactionInfo()
    {
        $response = $this->getClient()->getTransactionInfo($this->originalTransactionId);

        $this->testJWSTransactionDecodedPayload($response->getDecodedTransactionInfo());
    }

    public function testGetTransactionHistory()
    {
        $client = $this->getClient();
        $historyResponse = $client->getTransactionHistory($this->originalTransactionId);

        $this->assertInstanceOf(HistoryResponse::class, $historyResponse);
        $this->assertTrue(\strtolower($historyResponse->environment) == 'sandbox');
        $this->assertTrue(\is_null($historyResponse->appAppleId) || !empty($historyResponse->appAppleId));
        $this->assertNotEmpty($historyResponse->bundleId);
        $this->assertNotEmpty($historyResponse->revision);
        $this->assertIsArray($historyResponse->getDecodedTransactions());
        $this->assertNotEmpty($historyResponse->getDecodedTransactions());

        $transaction = $historyResponse->getDecodedTransactions()[0];

        $this->testJWSTransactionDecodedPayload($transaction);

        $historyResponseWithRevision = $client->getTransactionHistory(
            $this->originalTransactionId,
            $historyResponse->revision
        );

        $this->assertInstanceOf(HistoryResponse::class, $historyResponseWithRevision);
        $this->assertIsArray($historyResponseWithRevision->getDecodedTransactions());

        $params = new GetTransactionHistoryParams();
        $params->sort = $params::SORT_DESCENDING;

        $historyResponseWithParams = $client->getTransactionHistory($this->originalTransactionId, $params);

        $this->assertInstanceOf(HistoryResponse::class, $historyResponseWithParams);
        $this->assertIsArray($historyResponseWithParams->getDecodedTransactions());
    }

    public function testGetAllTransactionHistory()
    {
        $history = $this->getClient()->getAllTransactionHistory($this->originalTransactionId);
        $one = \current($history);

        $this->assertIsArray($history);
        $this->assertInstanceOf(JWSTransactionDecodedPayload::class, $one);
        $this->assertTrue($one->originalTransactionId == $this->originalTransactionId);
        $this->assertNotEmpty($one->bundleId);
        $this->assertNotEmpty($one->type);
        $this->assertNotEmpty($one->expiresDate);
        $this->assertNotEmpty($one->transactionId);
    }

    public function testGetAllSubscriptionStatuses()
    {
        $response = $this->getClient()->getAllSubscriptionStatuses($this->originalTransactionId);

        $this->assertInstanceOf(StatusResponse::class, $response);
        $this->assertNotEmpty($response->bundleId);
        $this->assertNotEmpty($response->environment);
        $this->assertIsArray($response->data);

        if (!empty($response->data)) {
            $info = $response->data[0];
            $this->assertInstanceOf(SubscriptionGroupIdentifierItem::class, $info);
            $this->assertNotEmpty($info->subscriptionGroupIdentifier);
            $this->assertIsString($info->subscriptionGroupIdentifier);
            $this->assertIsArray($info->lastTransactions);
            if ($info->lastTransactions) {
                $transaction = $info->lastTransactions[0];
                $this->assertInstanceOf(LastTransactionsItem::class, $transaction);
                $this->assertNotEmpty($transaction->originalTransactionId);
                $this->assertIsString($transaction->originalTransactionId);
                $this->assertNotEmpty($transaction->status);
                $this->assertIsInt($transaction->status);
                $this->assertNotEmpty($transaction->signedRenewalInfo);
                $this->assertIsString($transaction->signedRenewalInfo);
                $this->assertNotEmpty($transaction->signedTransactionInfo);
                $this->assertIsString($transaction->signedTransactionInfo);
                $this->assertNotEmpty($transaction->getDecodedTransactionInfo());
                $this->assertNotEmpty($transaction->getDecodedRenewalInfo());
                if ($transaction->getDecodedTransactionInfo()) {
                    $this->testJWSTransactionDecodedPayload($transaction->getDecodedTransactionInfo());
                }
                if ($transaction->getDecodedRenewalInfo()) {
                    $this->testJWSRenewalInfoDecodedPayload($transaction->getDecodedRenewalInfo());
                }
            }
        }

    }

    public function testGetRefundHistory()
    {
        $response = $this->getClient()->getRefundHistory($this->originalTransactionId);

        $this->assertIsArray($response->getDecodedTransactions());
    }

    public function testExtendSubscriptionRenewalDate()
    {
        $request = new ExtendRenewalDateRequest();
        $request->requestIdentifier = \uniqid();
        $request->extendByDays = 1;
        $request->extendReasonCode = 0;

        try {
            $response = $this->getClient()->extendSubscriptionRenewalDate($this->originalTransactionId, $request);
            $this->assertEquals($this->originalTransactionId, $response->originalTransactionId);
        } catch (AppleException $exception) {
            $this->assertTrue(
                $exception->getHttpStatus() == HttpStatus::BAD_REQUEST
                ||
                $exception->getHttpStatus() == HttpStatus::FORBIDDEN
            ); // The request is invalid and can’t be accepted.
        }
    }

    public function testRequestTestNotification()
    {
        $response = $this->getClient()->requestTestNotification();

        $this->assertNotEmpty($response->testNotificationToken);

        \sleep(3);

        $response = $this->getClient()->getTestNotificationStatus($response->testNotificationToken);

        $this->assertIsArray($response->sendAttempts);
        $this->assertNotEmpty($response->signedPayload);

        $attempts = $response->sendAttempts;
        $decodedPayload = $response->getDecodedPayload();

        if ($attempts) {
            $attempt = $attempts[0];
            $this->assertIsIntNotEmpty($attempt->attemptDate);
            $this->assertIsStringNotEmpty($attempt->sendAttemptResult);
        }

    }

    public function testGetNotificationHistory()
    {
        $client = $this->getClient();

        $params = new NotificationHistoryRequest();
        $params->startDate = (int)(new \DateTime())->sub(new \DateInterval("P1M"))->format('Uv');
        $params->endDate = (int)(new \DateTime())->format('Uv');

        $response = $client->getNotificationHistory($params);

        $this->assertIsBool($response->hasMore);
        $this->assertIsString($response->paginationToken);

        if ($response->notificationHistory) {
            foreach ($response->notificationHistory as $item) {
                $this->assertInstanceOf(NotificationHistoryResponseItem::class, $item);
                $this->assertNotEmpty($item->signedPayload);
                $this->assertNotEmpty($item->sendAttempts);
                $this->testNotificationsResponseBodyV2DecodedPayload($item->getDecodedPayload());
            }
        }
    }

    public function testExtendSubscriptionRenewalDatesForAllActiveSubscribers()
    {
        $client = $this->getClient();

        $request = new MassExtendRenewalDateRequest();
        $request->requestIdentifier = Uuid::v4();
        $request->extendByDays = 1;
        $request->extendReasonCode = 0;
        $request->productId = $this->getCredentials()['product_id'];

        $response = $client->extendSubscriptionRenewalDatesForAllActiveSubscribers($request);

        $this->assertNotEmpty($response->requestIdentifier);

        return $response->requestIdentifier;
    }

    /**
     * @param string $requestIdentifier
     * @depends testExtendSubscriptionRenewalDatesForAllActiveSubscribers
     * @throws \Exception
     */
    public function testGetStatusOfSubscriptionRenewalDateExtensions(string $requestIdentifier)
    {
        $client = $this->getClient();

        $response = $client->getStatusOfSubscriptionRenewalDateExtensions(
            $this->getCredentials()['product_id'],
            $requestIdentifier
        );

        $this->assertInstanceOf(MassExtendRenewalDateStatusResponse::class, $response);
        $this->assertNotEmpty($response->requestIdentifier);
        $this->assertIsBool($response->complete);

        if ($response->complete) {
            $this->assertIsInt($response->succeededCount);
            $this->assertIsInt($response->failedCount);
            $this->assertIsInt($response->completeDate);
        }
    }

    public function testCallApi()
    {
        $client = $this->getClient();

        $response = $client->callApi("GET", "inApps/v1/history/{$this->originalTransactionId}?revision=test");

        $body = $response->getBody()->getContents();

        $this->assertInstanceOf(ResponseInterface::class, $response);
        $this->assertNotEmpty($body);

        $model = new HistoryResponse($body);

        $this->assertNotEmpty($model->revision);
        $this->assertNotEmpty($model->environment);
        $this->assertNotEmpty($model->getDecodedTransactions());

        $this->expectException(AppleException::class);

        $client->callApi('DELETE', 'inApps/v1/notifications/test');
    }

    public function testCallApiBadPath()
    {
        $this->expectException(\Exception::class);

        $this->getClient()->callApi('GET', '/google');
    }

    public function testCallApiBadMethod()
    {
        $this->expectException(\Exception::class);

        $this->getClient()->callApi('test', 'inApps/v1/notifications/test');
    }

    protected function testJWSTransactionDecodedPayload(JWSTransactionDecodedPayload $transaction)
    {
        $this->assertTrue(\is_string($transaction->appAccountToken) || \is_null($transaction->appAccountToken), 'Bad appAccountToken');
        $this->assertIsStringNotEmpty($transaction->bundleId, 'Bad bundleId');
        $this->assertTrue(\is_string($transaction->currency) || \is_null($transaction->currency), 'Bad currency');
        $this->assertIsStringNotEmpty($transaction->environment, 'Bad environment');
        $this->assertIsIntNotEmpty($transaction->expiresDate, 'Bad expiresDate');
        $this->assertIsStringNotEmpty($transaction->inAppOwnershipType, 'Bad inAppOwnershipType');
        $this->assertTrue(\is_null($transaction->isUpgraded) || \is_bool($transaction->isUpgraded), 'Bad isUpgraded');
        $this->assertTrue(\is_null($transaction->offerDiscountType) || \is_string($transaction->offerDiscountType), 'Bad offerDiscountType');
        $this->assertTrue(\is_null($transaction->offerIdentifier) || \is_string($transaction->offerIdentifier), 'Bad offerIdentifier');
        $this->assertTrue(\is_null($transaction->offerType) || \is_int($transaction->offerType), 'Bad offerType');
        $this->assertIsIntNotEmpty($transaction->originalPurchaseDate, 'Bad originalPurchaseDate');
        $this->assertIsStringNotEmpty($transaction->originalTransactionId, 'Bad originalTransactionId');
        $this->assertTrue(\is_null($transaction->price) || \is_int($transaction->price), 'Bad price');
        $this->assertIsStringNotEmpty($transaction->productId, 'Bad productId');
        $this->assertIsIntNotEmpty($transaction->purchaseDate, 'Bad purchaseDate');
        $this->assertIsInt($transaction->quantity, 'Bad quantity');
        $this->assertTrue(\is_null($transaction->revocationDate) || \is_int($transaction->revocationDate), 'Bad revocationDate');
        $this->assertTrue(\is_null($transaction->revocationReason) || \is_string($transaction->revocationReason), 'Bad revocationReason');
        $this->assertIsIntNotEmpty($transaction->signedDate, 'Bad signedDate');
        $this->assertIsStringNotEmpty($transaction->storefront, 'Bad storefront');
        $this->assertIsStringNotEmpty($transaction->storefrontId, 'Bad storefrontId');
        $this->assertIsStringNotEmpty($transaction->subscriptionGroupIdentifier, 'Bad subscriptionGroupIdentifier');
        $this->assertIsStringNotEmpty($transaction->transactionId, 'Bad transactionId');
        $this->assertIsStringNotEmpty($transaction->transactionReason, 'Bad transactionReason');
        $this->assertIsStringNotEmpty($transaction->type, 'Bad type');
        $this->assertIsStringNotEmpty($transaction->webOrderLineItemId, 'Bad webOrderLineItemId');
    }

    protected function testJWSRenewalInfoDecodedPayload(JWSRenewalInfoDecodedPayload $info)
    {
        $this->assertIsStringNotEmpty($info->autoRenewProductId, 'Bad autoRenewProductId');
        $this->assertIsInt($info->autoRenewStatus, 'Bad autoRenewStatus');
        $this->assertIsStringNotEmpty($info->environment, 'Bad environment');
        $this->assertTrue(\is_null($info->expirationIntent) || \is_int($info->expirationIntent), 'Bad expirationIntent');
        $this->assertTrue(\is_null($info->gracePeriodExpiresDate) || \is_int($info->gracePeriodExpiresDate), 'Bad gracePeriodExpiresDate');
        $this->assertTrue(\is_null($info->isInBillingRetryPeriod) || \is_bool($info->isInBillingRetryPeriod), 'Bad isInBillingRetryPeriod');
        $this->assertTrue(\is_null($info->offerIdentifier) || \is_string($info->offerIdentifier), 'Bad offerIdentifier');
        $this->assertTrue(\is_null($info->offerType) || \is_int($info->offerType), 'Bad offerType');
        $this->assertIsStringNotEmpty($info->originalTransactionId, 'Bad originalTransactionId');
        $this->assertTrue(\is_null($info->priceIncreaseStatus) || \is_int($info->priceIncreaseStatus), 'Bad priceIncreaseStatus');
        $this->assertIsStringNotEmpty($info->productId, 'Bad productId');
        $this->assertIsIntNotEmpty($info->recentSubscriptionStartDate, 'Bad recentSubscriptionStartDate');
        $this->assertIsIntNotEmpty($info->renewalDate, 'Bad renewalDate');
        $this->assertIsIntNotEmpty($info->signedDate, 'Bad signedDate');
    }

    protected function testNotificationsResponseBodyV2DecodedPayload(NotificationsResponseBodyV2DecodedPayload $payload)
    {
        $this->assertIsStringNotEmpty($payload->notificationType, 'Bad notificationType');
        $this->assertIsStringNotEmpty($payload->notificationUUID, 'Bad notificationUUID');
        $this->assertIsStringNotEmpty($payload->version, 'Bad notificationVersion');
        if (!\is_null($payload->subtype)) {
            $this->assertIsStringNotEmpty($payload->subtype, 'Bad subtype');
        }
        if ($payload->data) {
            $this->testNotificationsResponseBodyV2DecodedPayloadData($payload->data);
        }
        if ($payload->summary) {
            $this->testNotificationsResponseBodyV2DecodedPayloadSummary($payload->summary);
        }
        if ($payload->externalPurchaseToken) {
            $this->testNotificationsResponseBodyV2DecodedPayloadExternalPurchaseToken($payload->externalPurchaseToken);
        }
    }

    protected function testNotificationsResponseBodyV2DecodedPayloadData(NotificationsResponseBodyV2DecodedPayloadData $data)
    {
        $this->assertTrue(\is_null($data->appAppleId) || \is_int($data->appAppleId), 'Bad appAppleId');
        $this->assertIsStringNotEmpty($data->bundleId, 'Bad bundleId');
        $this->assertIsStringNotEmpty($data->bundleVersion, 'Bad bundleVersion');
        $this->assertIsStringNotEmpty($data->environment, 'Bad environment');
        $this->assertTrue($data->getDecodedRenewalInfo() || $data->getDecodedTransactionInfo(), 'Empty useful data');
        if ($data->getDecodedTransactionInfo()) {
            $this->testJWSTransactionDecodedPayload($data->getDecodedTransactionInfo());
        }
        if ($data->getDecodedRenewalInfo()) {
            $this->testJWSRenewalInfoDecodedPayload($data->getDecodedRenewalInfo());
        }
    }

    protected function testNotificationsResponseBodyV2DecodedPayloadSummary(NotificationsResponseBodyV2DecodedPayloadSummary  $summary)
    {
        $this->assertIsStringNotEmpty($summary->requestIdentifier, 'Bad requestIdentifier');
        $this->assertIsStringNotEmpty($summary->environment, 'Bad environment');
        $this->assertTrue(\is_null($summary->appAppleId) || \is_int($summary->appAppleId), 'Bad appAppleId');
        $this->assertIsStringNotEmpty($summary->bundleId, 'Bad bundleId');
        $this->assertIsArray($summary->storefrontCountryCodes, 'Bad storefrontCountryCodes');
        $this->assertIsInt($summary->failedCount, 'Bad failedCount');
        $this->assertIsInt($summary->succeededCount, 'Bad succeededCount');
    }

    protected function testNotificationsResponseBodyV2DecodedPayloadExternalPurchaseToken(NotificationsResponseBodyV2DecodedPayloadExternalPurchaseToken $token)
    {
        $this->assertIsStringNotEmpty($token->externalPurchaseId, 'Bad externalPurchaseId');
        $this->assertIsInt($token->tokenCreationDate, 'Bad tokenCreationDate');
        $this->assertTrue(\is_null($token->appAppleId) || \is_int($token->appAppleId), 'Bad appAppleId');
        $this->assertIsStringNotEmpty($token->bundleId, 'Bad bundleId');
    }
}
