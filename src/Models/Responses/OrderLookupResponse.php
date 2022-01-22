<?php

namespace Nullform\AppStoreServerApiClient\Models\Responses;

use Nullform\AppStoreServerApiClient\AbstractModel;
use Nullform\AppStoreServerApiClient\Models\JWSTransactionDecodedPayload;
use Nullform\AppStoreServerApiClient\Tools;

/**
 * A response that includes the order lookup status and an array of signed transactions for the in-app purchases
 * in the order.
 *
 * @link https://developer.apple.com/documentation/appstoreserverapi/orderlookupresponse
 */
class OrderLookupResponse extends AbstractModel
{
    use SignedTransactionsTrait;

    /**
     * The status that indicates whether the order ID is valid.
     *
     * - 0: The orderId that you provided in the Look Up Order ID request is valid.
     * - 1: The orderId is invalid.
     *
     * @var int
     * @link https://developer.apple.com/documentation/appstoreserverapi/orderlookupstatus
     */
    public $status;
}
