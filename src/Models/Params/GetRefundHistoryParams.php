<?php

namespace Nullform\AppStoreServerApiClient\Models\Params;

use Nullform\AppStoreServerApiClient\AbstractModel;

/**
 * @link https://developer.apple.com/documentation/appstoreserverapi/get_refund_history#query-parameters
 */
class GetRefundHistoryParams extends AbstractModel
{
    /**
     * A token you provide to get the next set of up to 20 transactions.
     * All responses include a revision token.
     * Use the revision token from the previous RefundHistoryResponse.
     *
     * The revision token is required in all requests except the initial request.
     *
     * @var null|string
     * @link https://developer.apple.com/documentation/appstoreserverapi/revision
     */
    public $revision = null;
}
