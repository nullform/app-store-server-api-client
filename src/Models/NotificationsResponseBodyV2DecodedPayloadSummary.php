<?php

namespace Nullform\AppStoreServerApiClient\Models;

use Nullform\AppStoreServerApiClient\AbstractModel;
use Nullform\AppStoreServerApiClient\AppStoreServerApiClient;
use Nullform\AppStoreServerApiClient\Models\Requests\MassExtendRenewalDateRequest;

/**
 * The payload data for a subscription-renewal-date extension notification.
 *
 * @link https://developer.apple.com/documentation/appstoreservernotifications/summary
 */
class NotificationsResponseBodyV2DecodedPayloadSummary extends AbstractModel
{
    /**
     * The UUID that represents a specific request to extend a subscription renewal date.
     *
     * This value matches the value you initially specify in the requestIdentifier when you call
     * "Extend Subscription Renewal Dates for All Active Subscribers" in the App Store Server API.
     *
     * @var string
     * @link https://developer.apple.com/documentation/appstoreservernotifications/requestidentifier
     * @see AppStoreServerApiClient::extendSubscriptionRenewalDatesForAllActiveSubscribers()
     * @see MassExtendRenewalDateRequest::$requestIdentifier
     */
    public $requestIdentifier;

    /**
     * The server environment that the notification applies to, either sandbox or production.
     *
     * @var string
     * @link https://developer.apple.com/documentation/appstoreservernotifications/environment
     */
    public $environment;

    /**
     * The unique identifier of the app that the notification applies to.
     * This property is available for apps that users download from the App Store.
     *
     * It isn’t present in the sandbox environment.
     *
     * @var null|int
     */
    public $appAppleId = null;

    /**
     * The bundle identifier of the app.
     *
     * @var string
     */
    public $bundleId;

    /**
     * The product identifier of the auto-renewable subscription that the subscription-renewal-date extension
     * applies to.
     *
     * @var string
     */
    public $productId;

    /**
     * A list of country codes that limits the App Store’s attempt to apply the subscription-renewal-date extension.
     * If this list isn’t present, the subscription-renewal-date extension applies to all storefronts.
     *
     * @var string[]
     * @link https://developer.apple.com/documentation/appstoreservernotifications/storefrontcountrycodes
     */
    public $storefrontCountryCodes = [];

    /**
     * The final count of subscriptions that fail to receive a subscription-renewal-date extension.
     *
     * @var int
     */
    public $failedCount;

    /**
     * The final count of subscriptions that successfully receive a subscription-renewal-date extension.
     *
     * @var int
     */
    public $succeededCount;
}
