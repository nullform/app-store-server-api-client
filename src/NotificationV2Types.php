<?php

namespace Nullform\AppStoreServerApiClient;

/**
 * The type that describes the in-app purchase event for which the App Store sends the version 2 notification.
 *
 * @link https://developer.apple.com/documentation/appstoreservernotifications/notificationtype
 * @link https://developer.apple.com/documentation/appstoreservernotifications/app_store_server_notifications_changelog
 */
class NotificationV2Types
{
    /**
     * Indicates that the customer initiated a refund request for a consumable in-app purchase, and the
     * App Store is requesting that you provide consumption data. For more information, see Send Consumption Information.
     */
    public const CONSUMPTION_REQUEST = 'CONSUMPTION_REQUEST';

    /**
     * A notification type that along with its subtype indicates that the user made a change to their subscription plan.
     * If the subtype is UPGRADE, the user upgraded their subscription. The upgrade goes into effect immediately,
     * starting a new billing period, and the user receives a prorated refund for the unused portion of the previous
     * period. If the subtype is DOWNGRADE, the user downgraded or cross-graded their subscription. Downgrades take
     * effect at the next renewal. The currently active plan isn’t affected.
     *
     * If the subtype is empty, the user changed their renewal preference back to the current subscription,
     * effectively canceling a downgrade.
     */
    public const DID_CHANGE_RENEWAL_PREF = 'DID_CHANGE_RENEWAL_PREF';

    /**
     * A notification type that along with its subtype indicates that the user made a change to the subscription
     * renewal status. If the subtype is AUTO_RENEW_ENABLED, the user re-enabled subscription auto-renewal.
     * If the subtype is AUTO_RENEW_DISABLED, the user disabled subscription auto-renewal, or the App Store disabled
     * subscription auto-renewal after the user requested a refund.
     */
    public const DID_CHANGE_RENEWAL_STATUS = 'DID_CHANGE_RENEWAL_STATUS';

    /**
     * A notification type that along with its subtype indicates that the subscription failed to renew due to a billing
     * issue. The subscription enters the billing retry period. If the subtype is GRACE_PERIOD, continue to provide
     * service through the grace period. If the subtype is empty, the subscription isn’t in a grace period and you can
     * stop providing the subscription service.
     *
     * Inform the user that there may be an issue with their billing information. The App Store continues to retry
     * billing for 60 days, or until the user resolves their billing issue or cancels their subscription, whichever
     * comes first. For more information, see Reducing Involuntary Subscriber Churn.
     */
    public const DID_FAIL_TO_RENEW = 'DID_FAIL_TO_RENEW';

    /**
     * A notification type that along with its subtype indicates that the subscription successfully renewed.
     * If the subtype is BILLING_RECOVERY, the expired subscription that previously failed to renew now successfully
     * renewed. If the substate is empty, the active subscription has successfully auto-renewed for a new transaction
     * period. Provide the customer with access to the subscription’s content or service.
     */
    public const DID_RENEW = 'DID_RENEW';

    /**
     * A notification type that along with its subtype indicates that a subscription expired.
     * If the subtype is VOLUNTARY, the subscription expired after the user disabled subscription renewal.
     * If the subtype is BILLING_RETRY, the subscription expired because the billing retry period ended without a
     * successful billing transaction. If the subtype is PRICE_INCREASE, the subscription expired because the user
     * didn’t consent to a price increase.
     */
    public const EXPIRED = 'EXPIRED';

    /**
     * A notification type that, along with its subtype UNREPORTED, indicates that Apple created an external
     * purchase token for your app but didn't receive a report.
     *
     * This notification applies only to apps that use the External Purchase API to provide alternative payment options.
     */
    public const EXTERNAL_PURCHASE_TOKEN = 'EXTERNAL_PURCHASE_TOKEN';

    /**
     * Indicates that the billing grace period has ended without renewing the subscription, so you can turn off
     * access to service or content. Inform the user that there may be an issue with their billing information.
     * The App Store continues to retry billing for 60 days, or until the user resolves their billing issue or cancels
     * their subscription, whichever comes first. For more information, see Reducing Involuntary Subscriber Churn.
     */
    public const GRACE_PERIOD_EXPIRED = 'GRACE_PERIOD_EXPIRED';

    /**
     * A notification type that along with its subtype indicates that the user redeemed a promotional offer or offer code.
     *
     * If the subtype is INITIAL_BUY, the user redeemed the offer for a first-time purchase.
     * If the subtype is RESUBSCRIBE, the user redeemed an offer to resubscribe to an inactive subscription.
     * If the subtype is UPGRADE, the user redeemed an offer to upgrade their active subscription that goes into
     * effect immediately. If the subtype is DOWNGRADE, the user redeemed an offer to downgrade their active
     * subscription that goes into effect at the next renewal date. If the user redeemed an offer for their active
     * subscription, you receive an OFFER_REDEEMED notification type without a subtype.
     */
    public const OFFER_REDEEMED = 'OFFER_REDEEMED';

    /**
     * A notification type that along with its subtype indicates that the system has informed the user of a
     * subscription price increase. If the subtype is PENDING, the user hasn’t yet responded to the price increase.
     * If the subtype is ACCEPTED, the user has accepted the price increase.
     */
    public const PRICE_INCREASE = 'PRICE_INCREASE';

    /**
     * Indicates that the App Store successfully refunded a transaction for a consumable in-app purchase,
     * a non-consumable in-app purchase, an auto-renewable subscription, or a non-renewing subscription.
     */
    public const REFUND = 'REFUND';

    /**
     * Indicates that the App Store declined a refund request initiated by the app developer.
     */
    public const REFUND_DECLINED = 'REFUND_DECLINED';

    /**
     * A notification type that indicates the App Store reversed a previously granted refund due to a dispute that
     * the customer raised. If your app revoked content or services as a result of the related refund, it needs to
     * reinstate them.
     *
     * This notification type can apply to any in-app purchase type: consumable, non-consumable,
     * non-renewing subscription, and auto-renewable subscription.
     * For auto-renewable subscriptions, the renewal date remains unchanged when the App Store reverses a refund.
     */
    public const REFUND_REVERSED = 'REFUND_REVERSED';

    /**
     * Indicates that the App Store extended the subscription renewal date that the developer requested.
     */
    public const RENEWAL_EXTENDED = 'RENEWAL_EXTENDED';

    /**
     * A notification type that, along with its subtype, indicates that the App Store is attempting to extend
     * the subscription renewal date that you request by calling "Extend Subscription Renewal Dates for All
     * Active Subscribers".
     *
     * If the subtype is SUMMARY, the App Store completed extending the renewal date for all eligible subscribers.
     * If the subtype is FAILURE, the renewal date extension didn’t succeed for a specific subscription.
     */
    public const RENEWAL_EXTENSION = 'RENEWAL_EXTENSION';

    /**
     * Indicates that an in-app purchase the user was entitled to through Family Sharing is no longer available
     * through sharing. The App Store sends this notification when a purchaser disabled Family Sharing for a product,
     * the purchaser (or family member) left the family group, or the purchaser asked for and received a refund.
     */
    public const REVOKE = 'REVOKE';

    /**
     * A notification type that along with its subtype indicates that the user subscribed to a product.
     * If the subtype is INITIAL_BUY, the user either purchased or received access through Family Sharing
     * to the subscription for the first time. If the subtype is RESUBSCRIBE, the user resubscribed or received
     * access through Family Sharing to the same subscription or to another subscription within the same
     * subscription group.
     */
    public const SUBSCRIBED = 'SUBSCRIBED';

    /**
     * A notification type that the App Store server sends when you request it by calling the
     * Request a Test Notification endpoint.
     * You receive this notification only at your request.
     */
    public const TEST = 'TEST';
}
