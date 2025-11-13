<?php

namespace Nullform\AppStoreServerApiClient\Models;

use Nullform\AppStoreServerApiClient\AbstractModel;

/**
 * A decoded payload containing subscription renewal information.
 *
 * @link https://developer.apple.com/documentation/appstoreserverapi/jwsrenewalinfodecodedpayload
 */
class JWSRenewalInfoDecodedPayload extends AbstractModel
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
     * The identifier of the product that renews at the next billing period.
     *
     * @var string
     * @link https://developer.apple.com/documentation/appstoreserverapi/autorenewproductid
     */
    public $autoRenewProductId;

    /**
     * The renewal status for an auto-renewable subscription.
     *
     * - 0: Automatic renewal is off. The customer has turned off automatic renewal for the subscription,
     * and it won’t renew at the end of the current subscription period.
     * - 1: Automatic renewal is on. The subscription renews at the end of the current subscription period.
     *
     * @var int
     * @link https://developer.apple.com/documentation/appstoreserverapi/autorenewstatus
     */
    public $autoRenewStatus;

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
     * An array of win-back offer identifiers that a customer is eligible to redeem, which
     * sorts the identifiers with the best offers first.
     *
     * @var array|null
     * @link https://developer.apple.com/documentation/appstoreserverapi/eligiblewinbackofferids
     */
    public $eligibleWinBackOfferIds;

    /**
     * The server environment, either sandbox or production.
     *
     * @var string
     * @link https://developer.apple.com/documentation/appstoreserverapi/environment
     */
    public $environment;

    /**
     * The reason a subscription expired.
     *
     * - 1: The customer canceled their subscription.
     * - 2: Billing error; for example, the customer’s payment information was no longer valid.
     * - 3: The customer didn’t consent to a recent price increase.
     * - 4: The product wasn’t available for purchase at the time of renewal.
     *
     * @var int|null
     * @link https://developer.apple.com/documentation/appstoreserverapi/expirationintent
     */
    public $expirationIntent;

    /**
     * The time when the billing grace period for subscription renewals expires.
     *
     * @var int|null
     * @link https://developer.apple.com/documentation/appstoreserverapi/graceperiodexpiresdate
     */
    public $gracePeriodExpiresDate;

    /**
     * The Boolean value that indicates whether the App Store is attempting to automatically renew an expired
     * subscription.
     *
     * @var bool|null
     * @link https://developer.apple.com/documentation/appstoreserverapi/isinbillingretryperiod
     */
    public $isInBillingRetryPeriod;

    /**
     * The payment mode for a discount offer on an In-App Purchase.
     *
     * @var string|null
     * @link https://developer.apple.com/documentation/appstoreserverapi/offerdiscounttype
     */
    public $offerDiscountType;

    /**
     * The promo code or the promotional offer identifier.
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
     * The transaction identifier of the original purchase associated with this transaction.
     *
     * @var string
     * @link https://developer.apple.com/documentation/appstoreserverapi/originaltransactionid
     */
    public $originalTransactionId;

    /**
     * The status indicating whether a customer has approved a subscription price increase.
     *
     * - 0: The customer hasn’t yet responded to the subscription price increase.
     * - 1: The customer consented to the subscription price increase.
     *
     * @var int|null
     * @link https://developer.apple.com/documentation/appstoreserverapi/priceincreasestatus
     */
    public $priceIncreaseStatus;

    /**
     * The unique identifier for the product, that you create in App Store Connect.
     *
     * @var string
     * @link https://developer.apple.com/documentation/appstoreserverapi/productid
     */
    public $productId;

    /**
     * The earliest start date of an auto-renewable subscription in a series of subscription purchases that ignores
     * all lapses of paid service that are 60 days or fewer.
     *
     * @var int
     * @link https://developer.apple.com/documentation/appstoreserverapi/recentsubscriptionstartdate
     */
    public $recentSubscriptionStartDate;

    /**
     * The UNIX time, in milliseconds, that the most recent auto-renewable subscription purchase expires.
     *
     * @var int
     * @link https://developer.apple.com/documentation/appstoreserverapi/renewaldate
     */
    public $renewalDate;

    /**
     * The renewal price, in milliunits, of the auto-renewable subscription that renews at the next billing period.
     *
     * @var int|null
     * @link https://developer.apple.com/documentation/appstoreserverapi/renewalprice
     */
    public $renewalPrice = null;

    /**
     * The UNIX time, in milliseconds, that the App Store signed the JSON Web Signature data.
     *
     * @var int
     * @link https://developer.apple.com/documentation/appstoreserverapi/signeddate
     */
    public $signedDate;
}
