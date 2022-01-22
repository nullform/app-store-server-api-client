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
     * The bundle identifier of an app.
     *
     * @var string
     * @link https://developer.apple.com/documentation/appstoreserverapi/bundleid
     */
    public $bundleId;

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
     * The identifier that contains the promo code or the promotional offer identifier.
     *
     * @var string|null
     * @link https://developer.apple.com/documentation/appstoreserverapi/offeridentifier
     */
    public $offerIdentifier;

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
