<?php

namespace Nullform\AppStoreServerApiClient\Models\Requests;

use Nullform\AppStoreServerApiClient\AbstractModel;

/**
 * The request body that contains subscription-renewal-extension data to apply for all eligible active subscribers.
 *
 * @link https://developer.apple.com/documentation/appstoreserverapi/massextendrenewaldaterequest
 */
class MassExtendRenewalDateRequest extends AbstractModel
{
    /**
     * Required. A string that contains a one-time UUID value you provide to identify this subscription-renewal-date
     * extension request.
     *
     * Maximum Length: 128
     *
     * @var string
     * @link https://developer.apple.com/documentation/appstoreserverapi/requestidentifier
     */
    public $requestIdentifier;

    /**
     * Required. The number of days to extend the subscription renewal date.
     *
     * Maximum Value: 90
     *
     * @var int
     * @link https://developer.apple.com/documentation/appstoreserverapi/extendbydays
     */
    public $extendByDays;

    /**
     * Required. The reason code for the subscription-renewal-date extension.
     *
     * - 0 - Undeclared; no information provided.
     * - 1 - The renewal-date extension is for customer satisfaction.
     * - 2 - The renewal-date extension is for other reasons.
     * - 3 - The renewal-date extension is due to a service issue or outage.
     *
     * @var int
     * @link https://developer.apple.com/documentation/appstoreserverapi/extendreasoncode
     */
    public $extendReasonCode;

    /**
     * Required. The product identifier of the auto-renewable subscription that you’re requesting
     * the renewal-date extension for.
     *
     * @var string
     * @link https://developer.apple.com/documentation/appstoreserverapi/productid
     */
    public $productId;

    /**
     * A list of storefront country codes you provide to limit the storefronts that are eligible to receive the
     * subscription-renewal-date extension.
     *
     * Omit this list to request the subscription-renewal-date extension in all storefronts.
     *
     * @var string[]|null
     * @link https://developer.apple.com/documentation/appstoreserverapi/storefrontcountrycodes
     */
    public $storefrontCountryCodes = null;
}
