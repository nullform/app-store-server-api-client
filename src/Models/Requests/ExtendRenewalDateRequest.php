<?php

namespace Nullform\AppStoreServerApiClient\Models\Requests;

use Nullform\AppStoreServerApiClient\AbstractModel;

/**
 * The request body containing subscription-renewal-extension data.
 *
 * @link https://developer.apple.com/documentation/appstoreserverapi/extendrenewaldaterequest
 */
class ExtendRenewalDateRequest extends AbstractModel
{
    /**
     * Required. The number of days to extend the subscription renewal date.
     *
     * The number of days is a number from 1 to 90.
     *
     * @var int
     * @link https://developer.apple.com/documentation/appstoreserverapi/extendbydays
     */
    public $extendByDays;

    /**
     * Required. The reason code for the subscription date extension.
     *
     * - 0: Undeclared; no information provided.
     * - 1: The renewal-date extension is for customer satisfaction.
     * - 2: The renewal-date extension is for other reasons.
     * - 3: The renewal-date extension is due to a service issue or outage.
     *
     * @var int
     * @link https://developer.apple.com/documentation/appstoreserverapi/extendreasoncode
     */
    public $extendReasonCode;

    /**
     * Required. A string that contains a value you provide to uniquely identify this renewal-date-extension request.
     *
     * The maximum length of the string is 128 characters.
     *
     * @var string
     * @link https://developer.apple.com/documentation/appstoreserverapi/requestidentifier
     */
    public $requestIdentifier;
}
