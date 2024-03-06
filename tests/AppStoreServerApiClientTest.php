<?php

namespace Nullform\AppStoreServerApiClient\Tests;

use Nullform\AppStoreServerApiClient\Exceptions\AppleException;
use Nullform\AppStoreServerApiClient\Models\JWSTransactionDecodedPayload;
use Nullform\AppStoreServerApiClient\Models\Params\GetTransactionHistoryParams;
use Nullform\AppStoreServerApiClient\Models\Requests\ExtendRenewalDateRequest;
use Nullform\AppStoreServerApiClient\Models\Responses\HistoryResponse;
use Nullform\AppStoreServerApiClient\Models\Responses\StatusResponse;
use Nullform\HttpStatus;

class AppStoreServerApiClientTest extends AbstractTestCase
{
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
}
