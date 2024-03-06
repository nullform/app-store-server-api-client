<?php

namespace Nullform\AppStoreServerApiClient\Models\Params;

use Nullform\AppStoreServerApiClient\AbstractQueryParams;
use Nullform\AppStoreServerApiClient\Models\JWSTransactionDecodedPayload;

/**
 * @link https://developer.apple.com/documentation/appstoreserverapi/get_transaction_history#query-parameters
 */
class GetTransactionHistoryParams extends AbstractQueryParams
{
    public const SORT_ASCENDING = 'ASCENDING';
    public const SORT_DESCENDING = 'DESCENDING';

    public const PRODUCT_TYPE_AUTO_RENEWABLE = 'AUTO_RENEWABLE';
    public const PRODUCT_TYPE_NON_RENEWABLE = 'NON_RENEWABLE';
    public const PRODUCT_TYPE_CONSUMABLE = 'CONSUMABLE';
    public const PRODUCT_TYPE_NON_CONSUMABLE = 'NON_CONSUMABLE';

    /**
     * A token you provide to get the next set of up to 20 transactions.
     *
     * @var null|string
     * @link https://developer.apple.com/documentation/appstoreserverapi/revision
     */
    public $revision = null;

    /**
     * The start date of a timespan, expressed in UNIX time, in milliseconds.
     *
     * An optional start date of the timespan for the transaction history records you’re requesting.
     * The startDate needs to precede the endDate if you specify both dates.
     * The results include a transaction if its purchaseDate is equal to or greater than the startDate.
     *
     * @var null|int
     * @link https://developer.apple.com/documentation/appstoreserverapi/startdate
     */
    public $startDate = null;

    /**
     * The end date of a timespan, expressed in UNIX time, in milliseconds.
     *
     * An optional end date of the timespan for the transaction history records you’re requesting.
     * Choose an endDate that’s later than the startDate if you specify both dates.
     * Using an endDate in the future is valid.
     * The results include a transaction if its purchaseDate is earlier than the endDate.
     *
     * @var null|int
     */
    public $endDate = null;

    /**
     * The unique identifier for the product, that you create in App Store Connect.
     *
     * An optional filter that indicates the product identifier to include in the transaction history.
     *
     * Your query may specify more than one productID.
     *
     * @var null|string|string[]
     */
    public $productId = null;

    /**
     * An optional filter that indicates the product type to include in the transaction history.
     * Your query may specify more than one productType.
     *
     * Possible Values: AUTO_RENEWABLE, NON_RENEWABLE, CONSUMABLE, NON_CONSUMABLE
     *
     * @var null|string|string[]
     * @see GetTransactionHistoryParams::PRODUCT_TYPE_AUTO_RENEWABLE
     * @see GetTransactionHistoryParams::PRODUCT_TYPE_NON_RENEWABLE
     * @see GetTransactionHistoryParams::PRODUCT_TYPE_CONSUMABLE
     * @see GetTransactionHistoryParams::PRODUCT_TYPE_NON_CONSUMABLE
     */
    public $productType = null;

    /**
     * An optional sort order for the transaction history records.
     * The response sorts the transaction records by their recently modified date.
     * The default value is ASCENDING, so you receive the oldest records first.
     *
     * Possible Values: ASCENDING, DESCENDING
     *
     * @var null|string
     * @see GetTransactionHistoryParams::SORT_ASCENDING
     * @see GetTransactionHistoryParams::SORT_DESCENDING
     */
    public $sort = null;

    /**
     * An optional filter that indicates the subscription group identifier to include in the transaction history.
     *
     * Your query may specify more than one subscriptionGroupIdentifier.
     *
     * @var null|string|string[]
     * @see JWSTransactionDecodedPayload::$subscriptionGroupIdentifier
     */
    public $subscriptionGroupIdentifier = null;

    /**
     * An optional filter that limits the transaction history by the in-app ownership type.
     *
     * @var null|string
     * @see JWSTransactionDecodedPayload::$inAppOwnershipType
     */
    public $inAppOwnershipType = null;

    /**
     * An optional Boolean value that indicates whether the response includes only revoked transactions
     * when the value is true, or contains only nonrevoked transactions when the value is false.
     * By default, the request doesn't include this parameter.
     *
     * @var null|bool
     */
    public $revoked = null;
}
