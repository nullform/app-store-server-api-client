<?php

namespace Nullform\AppStoreServerApiClient\Models\Responses;

/**
 * A response that contains an array of signed JSON Web Signature (JWS) refunded transactions, and paging information.
 *
 * @link https://developer.apple.com/documentation/appstoreserverapi/refundhistoryresponse
 */
class RefundHistoryResponse extends RefundLookupResponse
{
    /**
     * A Boolean value that indicates whether the App Store has more transactions than it returns in signedTransactions.
     * If the value is true, use the revision token to request the next set of transactions.
     *
     * @var bool
     * @link https://developer.apple.com/documentation/appstoreserverapi/hasmore
     */
    public $hasMore;

    /**
     * A token you provide in a query to request the next set of transactions.
     *
     * @var string
     * @link https://developer.apple.com/documentation/appstoreserverapi/revision
     */
    public $revision;
}
