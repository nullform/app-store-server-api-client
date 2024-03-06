<?php

namespace Nullform\AppStoreServerApiClient\Tests;

use Nullform\AppStoreServerApiClient\Exceptions\AppleException;
use Nullform\AppStoreServerApiClient\Models\JWSTransactionDecodedPayload;
use Nullform\AppStoreServerApiClient\Models\Params\GetTransactionHistoryParams;
use Nullform\AppStoreServerApiClient\Models\Requests\ExtendRenewalDateRequest;
use Nullform\AppStoreServerApiClient\Models\Responses\HistoryResponse;
use Nullform\AppStoreServerApiClient\Models\Responses\StatusResponse;
use Nullform\HttpStatus;
use Psr\Http\Message\ResponseInterface;

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
        $this->assertNotEmpty($historyResponse->getDecodedTransactions());

        $transaction = $historyResponse->getDecodedTransactions()[0];

        $this->assertNotEmpty($transaction);
        $this->assertInstanceOf(JWSTransactionDecodedPayload::class, $transaction);
        $this->assertNotEmpty($transaction->appAccountToken);
        $this->assertNotEmpty($transaction->originalTransactionId);
        $this->assertNotEmpty($transaction->environment);
        $this->assertNotEmpty($transaction->type);

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
}
