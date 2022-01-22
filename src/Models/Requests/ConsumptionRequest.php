<?php

namespace Nullform\AppStoreServerApiClient\Models\Requests;

use Nullform\AppStoreServerApiClient\AbstractModel;

/**
 * The request body containing consumption information.
 *
 * @link https://developer.apple.com/documentation/appstoreserverapi/consumptionrequest
 */
class ConsumptionRequest extends AbstractModel
{
    /**
     * (Required) The age of the customer’s account.
     *
     * @var int
     * @link https://developer.apple.com/documentation/appstoreserverapi/accounttenure
     */
    public $accountTenure;

    /**
     * (Required) The UUID of the in-app user account that completed the consumable in-app purchase transaction.
     *
     * @var string
     * @link https://developer.apple.com/documentation/appstoreserverapi/appaccounttoken
     */
    public $appAccountToken;

    /**
     * (Required) A value that indicates the extent to which the customer consumed the in-app purchase.
     *
     * @var int
     * @link https://developer.apple.com/documentation/appstoreserverapi/consumptionstatus
     */
    public $consumptionStatus;

    /**
     * (Required) A Boolean value of true or false that indicates whether the customer consented to provide
     * consumption data.
     *
     * @var bool
     * @link https://developer.apple.com/documentation/appstoreserverapi/customerconsented
     */
    public $customerConsented;

    /**
     * (Required) A value that indicates whether the app successfully delivered an in-app purchase that works properly.
     *
     * @var int
     * @link https://developer.apple.com/documentation/appstoreserverapi/deliverystatus
     */
    public $deliveryStatus;

    /**
     * (Required) A value that indicates the total amount, in USD, of in-app purchases the customer has made in your
     * app, across all platforms.
     *
     * @var int
     * @link https://developer.apple.com/documentation/appstoreserverapi/lifetimedollarspurchased
     */
    public $lifetimeDollarsPurchased;

    /**
     * (Required) A value that indicates the total amount, in USD, of refunds the customer has received, in your app,
     * across all platforms.
     *
     * @var int
     * @link https://developer.apple.com/documentation/appstoreserverapi/lifetimedollarsrefunded
     */
    public $lifetimeDollarsRefunded;

    /**
     * (Required) A value that indicates the platform on which the customer consumed the in-app purchase.
     *
     * @var int
     * @link https://developer.apple.com/documentation/appstoreserverapi/platform
     */
    public $platform;

    /**
     * (Required) A value that indicates the amount of time that the customer used the app.
     *
     * @var int
     * @link https://developer.apple.com/documentation/appstoreserverapi/playtime
     */
    public $playTime;

    /**
     * (Required) A Boolean value of true or false that indicates whether you provided, prior to its purchase, a
     * free sample or trial of the content, or information about its functionality.
     *
     * @var bool
     * @link https://developer.apple.com/documentation/appstoreserverapi/samplecontentprovided
     */
    public $sampleContentProvided;

    /**
     * (Required) The status of the customer’s account.
     *
     * @var int
     * @link https://developer.apple.com/documentation/appstoreserverapi/userstatus
     */
    public $userStatus;
}
