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
     * The reason a subscription expired.
     *
     * - 1: The customer canceled their subscription.
     * - 2: Billing error; for example, the customer’s payment information was no longer valid.
     * - 3: The customer didn’t consent to a recent price increase.
     * - 4: The product wasn’t available for purchase at the time of renewal.
     *
     * @var int
     * @link https://developer.apple.com/documentation/appstoreserverapi/expirationintent
     */
    public $expirationIntent;

    /**
     * The time when the billing grace period for subscription renewals expires.
     *
     * @var int
     * @link https://developer.apple.com/documentation/appstoreserverapi/graceperiodexpiresdate
     */
    public $gracePeriodExpiresDate;

    /**
     * The Boolean value that indicates whether the App Store is attempting to automatically renew an expired
     * subscription.
     *
     * @var bool
     * @link https://developer.apple.com/documentation/appstoreserverapi/isinbillingretryperiod
     */
    public $isInBillingRetryPeriod;

    /**
     * The promo code or the promotional offer identifier.
     *
     * @var string
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
     * @var int
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
     * @var int
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
     * The UNIX time, in milliseconds, that the App Store signed the JSON Web Signature data.
     *
     * @var int
     * @link https://developer.apple.com/documentation/appstoreserverapi/signeddate
     */
    public $signedDate;
}
