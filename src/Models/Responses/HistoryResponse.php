<?php

namespace Nullform\AppStoreServerApiClient\Models\Responses;

use Nullform\AppStoreServerApiClient\AbstractModel;
use Nullform\AppStoreServerApiClient\Models\JWSTransactionDecodedPayload;
use Nullform\AppStoreServerApiClient\Tools;

/**
 * A response that contains the customer’s transaction history for an app.
 *
 * @link https://developer.apple.com/documentation/appstoreserverapi/historyresponse
 */
class HistoryResponse extends AbstractModel
{
    use SignedTransactionsTrait;

    /**
     * The unique identifier of an app in the App Store.
     *
     * @var int
     * @link https://developer.apple.com/documentation/appstoreserverapi/appappleid
     */
    public $appAppleId;

    /**
     * The bundle identifier of an app.
     *
     * @var string
     * @link https://developer.apple.com/documentation/appstoreserverapi/bundleid
     */
    public $bundleId;

    /**
     * The server environment, either sandbox or production.
     *
     * @var string
     * @link https://developer.apple.com/documentation/appstoreserverapi/environment
     */
    public $environment;

    /**
     * A Boolean value indicating whether the App Store has more transaction data.
     *
     * @var bool
     * @link https://developer.apple.com/documentation/appstoreserverapi/hasmore
     */
    public $hasMore;

    /**
     * A token you use in a query to request the next set of transactions for the customer.
     *
     * @var string
     * @link https://developer.apple.com/documentation/appstoreserverapi/revision
     */
    public $revision;
}
