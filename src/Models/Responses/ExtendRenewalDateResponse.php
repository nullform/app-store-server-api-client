<?php

namespace Nullform\AppStoreServerApiClient\Models\Responses;

use Nullform\AppStoreServerApiClient\AbstractModel;

/**
 * A response that indicates whether the renewal-date extension succeeded and related details.
 *
 * @link https://developer.apple.com/documentation/appstoreserverapi/extendrenewaldateresponse
 */
class ExtendRenewalDateResponse extends AbstractModel
{
    /**
     * The date that the successful subscription-renewal extension begins.
     *
     * @var int
     * @link https://developer.apple.com/documentation/appstoreserverapi/effectivedate
     */
    public $effectiveDate;

    /**
     * The original transaction identifier of the subscription that experienced a service interruption.
     *
     * @var string
     * @link https://developer.apple.com/documentation/appstoreserverapi/originaltransactionid
     */
    public $originalTransactionId;

    /**
     * A Boolean value that indicates whether the subscription-renewal-date extension succeeded.
     *
     * @var bool
     * @link https://developer.apple.com/documentation/appstoreserverapi/success
     */
    public $success;

    /**
     * A unique ID that identifies subscription-purchase events including subscription renewals, across devices.
     *
     * @var string
     * @link https://developer.apple.com/documentation/appstoreserverapi/weborderlineitemid
     */
    public $webOrderLineItemId;
}
