# Apple App Store Server API PHP Client

Unoffical PHP client for [App Store Server API](https://developer.apple.com/documentation/appstoreserverapi) and [App Store Server Notifications](https://developer.apple.com/documentation/appstoreservernotifications).

## Installation

### Requirements

- PHP >= 7.2

### Composer

```shell
composer require nullform/app-store-server-api-client
```

## Usage

Create an API Key instance:

```php
// As instance of anonymous class...
$apiKey = new class extends AbstractApiKey {};
$apiKey->setPrivateKey(\file_get_contents($privateKeyFile));
$apiKey->setPrivateKeyId('Your private key id');
$apiKey->setIssuerId('Your issuer id');
$apiKey->setName('Key name (optional)');

// ... or as instance of ApiKey
$apiKey = new ApiKey(
    \file_get_contents($privateKeyFile),
    'Your private key id',
    'Your issuer id',
    'Key name (optional)'
);
```

Create a Bundle instance(s):

```php
// As instance of anonymous class...
$bundle = new class extends AbstractBundle {};
$bundle->setBundleId('Your bundle id');
$bundle->setName('Bundle name (optional)');

// ... or as instance of Bundle
$bundle2 = new Bundle('Your bundle #2 id');
```

Create an API client instance:

```php
$client = new AppStoreServerApiClient($apiKey, $bundle, Environment::PRODUCTION);
```

Use client for one or multiple bundles:

```php
try {
    $historyResponse = $client->getTransactionHistory($originalTransactionId);
    $transactions = $historyResponse->getDecodedTransactions();
} catch (HttpClientException $httpClientException) {
    echo "HTTP client error: " . $httpClientException->getMessage();
} catch (AppleException $appleException) {
    echo "Apple error ({$appleException->getCode()}): " . $appleException->getMessage();
}

try {
    $bundle2HistoryResponse = $client->setBundle($bundle2)->getTransactionHistory($originalTransactionId);
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}
```

You can manually call the App Store Server API via universal **callApi()** method:

```php
use Nullform\AppStoreServerApiClient\AppStoreServerApiClient;
use Nullform\AppStoreServerApiClient\AbstractModel;
use Nullform\AppStoreServerApiClient\Environment;

$apiKey = new MyApiKey(); // Extends AbstractApiKey
$bundle = new MyBundle(); // Extends AbstractBundle
$client = new AppStoreServerApiClient($apiKey, $bundle, Environment::SANDBOX);

$queryParams = new class extends AbstractModel {
    public $param = 'value';
};
$requestBody = new class extends AbstractModel {
    public $bodyParam = 'value';
};

// Get instance of ResponseInterface
$response = $client->callApi("POST", "inApps/v1/notifications/test", $queryParams, $requestBody);
// Get response body
$responseBody = $response->getBody()->getContents();
```

## AppStoreServerApiClient methods

### Get Transaction History

```php
AppStoreServerApiClient::getTransactionHistory(
    string $transactionId,
    null|string|GetTransactionHistoryParams $paramsOrRevision = null
): HistoryResponse
```

Get a customer’s in-app purchase transaction history for your app.

https://developer.apple.com/documentation/appstoreserverapi/get_transaction_history

### Get All Transactions History

```php
AppStoreServerApiClient::getAllTransactionHistory(
    string $transactionId
): JWSTransactionDecodedPayload[]
```

Recursively get FULL transaction history.

### Get Transaction Info

```php
AppStoreServerApiClient::getTransactionInfo(
    string $transactionId
): TransactionInfoResponse
```

Get information about a single transaction for your app.

https://developer.apple.com/documentation/appstoreserverapi/get_transaction_info

### Get All Subscription Statuses

```php
AppStoreServerApiClient::getAllSubscriptionStatuses(
    string $transactionId
): StatusResponse
```

Get the statuses for all of a customer’s subscriptions in your app.

https://developer.apple.com/documentation/appstoreserverapi/get_all_subscription_statuses

### Send Consumption Information

```php
AppStoreServerApiClient::sendConsumptionInformation(
    string $transactionId,
    ConsumptionRequest $request
): void
```

Send consumption information about a consumable in-app purchase to the App Store after your server receives a consumption request notification.

https://developer.apple.com/documentation/appstoreserverapi/send_consumption_information

### Look Up Order Id

```php
AppStoreServerApiClient::lookUpOrderId(
    string $orderId
): OrderLookupResponse
```

Get a customer’s in-app purchases from a receipt using the order ID.

https://developer.apple.com/documentation/appstoreserverapi/look_up_order_id

### Get Refund History

```php
AppStoreServerApiClient::getRefundHistory(
    string $transactionId
): RefundLookupResponse
```

Get a list of all refunded in-app purchases in your app for a customer.

https://developer.apple.com/documentation/appstoreserverapi/get_refund_history

### Extend a Subscription Renewal Date

```php
AppStoreServerApiClient::extendSubscriptionRenewalDate(
    string $originalTransactionId,
    ExtendRenewalDateRequest $request
): ExtendRenewalDateResponse
```

Extend the renewal date of a customer’s active subscription using the original transaction identifier.

https://developer.apple.com/documentation/appstoreserverapi/extend_a_subscription_renewal_date

### Extend Subscription Renewal Dates for All Active Subscribers

```php
AppStoreServerApiClient::extendSubscriptionRenewalDatesForAllActiveSubscribers(
    MassExtendRenewalDateRequest $request
): MassExtendRenewalDateResponse
```

Uses a subscription’s product identifier to extend the renewal date for all of its eligible active subscribers.

https://developer.apple.com/documentation/appstoreserverapi/extend_subscription_renewal_dates_for_all_active_subscribers

### Get Status of Subscription Renewal Date Extensions

```php
AppStoreServerApiClient::getStatusOfSubscriptionRenewalDateExtensions(
    string $productId,
    string $requestIdentifier
): MassExtendRenewalDateStatusResponse
```

Checks whether a renewal date extension request completed, and provides the final count of successful or failed extensions.

https://developer.apple.com/documentation/appstoreserverapi/get_status_of_subscription_renewal_date_extensions

### Request a Test Notification

```php
AppStoreServerApiClient::requestTestNotification(): SendTestNotificationResponse
```

Ask App Store Server Notifications to send a test notification to your server.

https://developer.apple.com/documentation/appstoreserverapi/request_a_test_notification

### Get Test Notification Status

```php
AppStoreServerApiClient::getTestNotificationStatus(
    string $testNotificationToken
): CheckTestNotificationResponse
```

Check the status of the test App Store server notification sent to your server.

https://developer.apple.com/documentation/appstoreserverapi/get_test_notification_status

### Get Notification History

```php
AppStoreServerApiClient::getNotificationHistory(
    NotificationHistoryRequest $params,
    ?string $paginationToken = null
): CheckTestNotificationResponse
```

Get a list of notifications that the App Store server attempted to send to your server.

https://developer.apple.com/documentation/appstoreserverapi/get_notification_history

### Set App Store Bundle

```php
AppStoreServerApiClient::setBundle(
    BundleInterface $bundle
): self
```

Set App Store bundle for authorize your API calls.

### Set Token TTL

```php
AppStoreServerApiClient::setTokenTtl(
    int $ttl
): self
```

Set new value for JWT TTL (in seconds). Maximum value: 3600.

https://developer.apple.com/documentation/appstoreserverapi/generating_tokens_for_api_requests

### Set HTTP Client Request Timeout

```php
AppStoreServerApiClient::setHttpClientRequestTimeout(
    float $timeout
): self
```

Set new value for HTTP client request timeout (in seconds).

### Call API

```php
AppStoreServerApiClient::callApi(
    string $method,
    string $path,
    ?AbstractModel $params = null,
    ?AbstractModel $body = null
): \Psr\Http\Message\ResponseInterface
```

Custom call App Store Server API with your previously passed credentials.

## Receiving App Store Server Notifications V2

To receive [App Store Server Notifications](https://developer.apple.com/documentation/appstoreservernotifications)
use **AppStoreServerNotificationsClient**:

```php
$notificationClient = new AppStoreServerNotificationsClient();

try {
    $payload = $notificationClient->receive($requestBody);
} catch (NotificationBadRequestException $exception) {
    echo $exception->getMessage();
}
```

Note that AppStoreServerNotificationsClient only for version 2 notifications.

## Tests

For unit tests you must create *credentials.php* and *private-key.p8* with the key and sandbox credentials from App Store Connect (see *tests/credentials.example.php*).
