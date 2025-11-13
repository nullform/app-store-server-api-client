<?php

namespace Nullform\AppStoreServerApiClient\Models;

use Nullform\AppStoreServerApiClient\AbstractModel;

/**
 * A decoded payload containing transaction information.
 *
 * @link https://developer.apple.com/documentation/appstoreserverapi/jwstransactiondecodedpayload
 */
class JWSTransactionDecodedPayload extends AbstractModel
{
    /**
     * The UUID an app optionally generates to map a customer’s in-app purchase with its resulting App Store transaction.
     *
     * @var string|null
     * @link https://developer.apple.com/documentation/appstoreserverapi/appaccounttoken
     */
    public $appAccountToken;

    /**
     * The unique identifier of the app download transaction.
     *
     * @var string
     * @link https://developer.apple.com/documentation/appstoreserverapi/apptransactionid
     */
    public $appTransactionId;

    /**
     * The bundle identifier of an app.
     *
     * @var string
     * @link https://developer.apple.com/documentation/appstoreserverapi/bundleid
     */
    public $bundleId;

    /**
     * The three-letter ISO 4217 currency code associated with the price parameter.
     *
     * This value is present only if price is present.
     *
     * @var string|null
     * @link https://developer.apple.com/documentation/appstoreserverapi/currency
     */
    public $currency = null;

    /**
     * The server environment, either sandbox or production.
     *
     * @var string
     * @link https://developer.apple.com/documentation/appstoreserverapi/environment
     */
    public $environment;

    /**
     * The UNIX time, in milliseconds, a subscription expires or renews.
     *
     * @var int
     * @link https://developer.apple.com/documentation/appstoreserverapi/expiresdate
     */
    public $expiresDate;

    /**
     * A string that describes whether the transaction was purchased by the user, or is available to them through
     * Family Sharing.
     *
     * Possible values:
     *
     * - FAMILY_SHARED - The transaction belongs to a family member who benefits from service.
     * - PURCHASED - The transaction belongs to the purchaser.
     *
     * @var string
     * @link https://developer.apple.com/documentation/appstoreserverapi/inappownershiptype
     */
    public $inAppOwnershipType;

    /**
     * The Boolean value that indicates whether the user upgraded to another subscription.
     *
     * @var bool|null
     * @link https://developer.apple.com/documentation/appstoreserverapi/isupgraded
     */
    public $isUpgraded;

    /**
     * The payment mode you configure for the subscription offer, such as Free Trial, Pay As You Go, or Pay Up Front.
     *
     * @var string|null
     * @link https://developer.apple.com/documentation/appstoreserverapi/offerdiscounttype
     */
    public $offerDiscountType;

    /**
     * The identifier that contains the promo code or the promotional offer identifier.
     *
     * @var string|null
     * @link https://developer.apple.com/documentation/appstoreserverapi/offeridentifier
     */
    public $offerIdentifier;

    /**
     * The duration of the offer.
     *
     * This field is in ISO 8601 duration format.
     * The following table shows examples of offer period values.
     *
     * Single period length - Period count - Offer period value
     * 1 month - 1 - P1M
     * 1 month - 2 - P2M
     * 3 days - 1 - P3D
     *
     * @var string|null
     * @link https://developer.apple.com/documentation/appstoreserverapi/offerperiod
     */
    public $offerPeriod;

    /**
     * The type of promotional offer.
     *
     * - 1: An introductory offer.
     * - 2: A promotional offer.
     * - 3: An offer with a subscription offer code.
     *
     * @var int|null
     * @link https://developer.apple.com/documentation/appstoreserverapi/offertype
     */
    public $offerType;

    /**
     * The UNIX time, in milliseconds, that represents the purchase date of the original transaction identifier.
     *
     * @var int
     * @link https://developer.apple.com/documentation/appstoreserverapi/originalpurchasedate
     */
    public $originalPurchaseDate;

    /**
     * The transaction identifier of the original purchase.
     *
     * @var string
     * @link https://developer.apple.com/documentation/appstoreserverapi/originaltransactionid
     */
    public $originalTransactionId;

    /**
     * An integer value that represents the price multiplied by 1000 of the in-app purchase or subscription offer
     * you configured in App Store Connect and that the system records at the time of the purchase.
     *
     * @var int|null
     * @link https://developer.apple.com/documentation/appstoreserverapi/price
     */
    public $price = null;

    /**
     * The unique identifier for the product, that you create in App Store Connect.
     *
     * @var string
     * @link https://developer.apple.com/documentation/appstoreserverapi/productid
     */
    public $productId;

    /**
     * The UNIX time, in milliseconds, that the App Store charged the user’s account for a purchase, restored product,
     * subscription, or subscription renewal after a lapse.
     *
     * @var int
     * @link https://developer.apple.com/documentation/appstoreserverapi/purchasedate
     */
    public $purchaseDate;

    /**
     * The number of consumable products the user purchased.
     *
     * @var int
     * @link https://developer.apple.com/documentation/appstoreserverapi/quantity
     */
    public $quantity;

    /**
     * The UNIX time, in milliseconds, that Apple Support refunded a transaction.
     *
     * @var int|null
     * @link https://developer.apple.com/documentation/appstoreserverapi/revocationdate
     */
    public $revocationDate;

    /**
     * The reason that the App Store refunded the transaction or revoked it from family sharing.
     *
     * @var string|null
     * @link https://developer.apple.com/documentation/appstoreserverapi/revocationreason
     */
    public $revocationReason;

    /**
     * The UNIX time, in milliseconds, that the App Store signed the JSON Web Signature (JWS) data.
     *
     * @var int
     * @link https://developer.apple.com/documentation/appstoreserverapi/signeddate
     */
    public $signedDate;

    /**
     * The three-letter code that represents the country or region associated with the App Store storefront
     * for the purchase.
     *
     * @var string
     * @link https://developer.apple.com/documentation/appstoreserverapi/storefront
     */
    public $storefront;

    /**
     * An Apple-defined value that uniquely identifies the App Store storefront associated with the purchase.
     *
     * @var string
     * @link https://developer.apple.com/documentation/appstoreserverapi/storefrontid
     */
    public $storefrontId;

    /**
     * The identifier of the subscription group that the subscription belongs to.
     *
     * @var string
     * @link https://developer.apple.com/documentation/appstoreserverapi/subscriptiongroupidentifier
     */
    public $subscriptionGroupIdentifier;

    /**
     * The unique identifier for a transaction such as an in-app purchase, restored in-app purchase, or
     * subscription renewal.
     *
     * @var string
     * @link https://developer.apple.com/documentation/appstoreserverapi/transactionid
     */
    public $transactionId;

    /**
     * The reason for the purchase transaction, which indicates whether it’s a customer’s purchase or a renewal
     * for an auto-renewable subscription that the system initates.
     *
     * - PURCHASE
     * - RENEWAL
     *
     * @var string
     * @link https://developer.apple.com/documentation/appstoreserverapi/transactionreason
     */
    public $transactionReason;

    /**
     * The type of in-app purchase products you can offer in your app.
     *
     * - Auto-Renewable Subscription
     * - Non-Consumable
     * - Consumable
     * - Non-Renewing Subscription
     *
     * @var string
     * @link https://developer.apple.com/documentation/appstoreserverapi/type
     */
    public $type;

    /**
     * A unique ID that identifies subscription purchase events across devices, including subscription renewals.
     *
     * @var string
     * @link https://developer.apple.com/documentation/appstoreserverapi/weborderlineitemid
     */
    public $webOrderLineItemId;
}
