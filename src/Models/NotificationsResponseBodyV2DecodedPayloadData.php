<?php

namespace Nullform\AppStoreServerApiClient\Models;

use Nullform\AppStoreServerApiClient\AbstractModel;
use Nullform\AppStoreServerApiClient\Tools;

/**
 * The app metadata and signed renewal and transaction information.
 *
 * @link https://developer.apple.com/documentation/appstoreservernotifications/data
 */
class NotificationsResponseBodyV2DecodedPayloadData extends AbstractModel
{
    /**
     * The unique identifier of an app in the App Store.
     *
     * @var int|null
     * @link https://developer.apple.com/documentation/appstoreservernotifications/appappleid
     */
    public $appAppleId;

    /**
     * The bundle identifier of the app.
     *
     * @var string
     * @link https://developer.apple.com/documentation/appstoreservernotifications/bundleid
     */
    public $bundleId;

    /**
     * The version of the build that identifies an iteration of the bundle.
     *
     * @var string
     * @link https://developer.apple.com/documentation/appstoreservernotifications/bundleversion
     */
    public $bundleVersion;

    /**
     * The server environment that the notification applies to, either sandbox or production.
     *
     * @var string
     * @link https://developer.apple.com/documentation/appstoreservernotifications/environment
     */
    public $environment;

    /**
     * Subscription renewal information signed by the App Store, in JSON Web Signature format.
     *
     * @var string|null
     * @link https://developer.apple.com/documentation/appstoreservernotifications/jwsrenewalinfo
     */
    public $signedRenewalInfo;

    /**
     * Transaction information signed by the App Store, in JSON Web Signature format.
     *
     * @var string|null
     * @link https://developer.apple.com/documentation/appstoreservernotifications/jwstransaction
     */
    public $signedTransactionInfo;

    /**
     * Get decoded subscription renewal information.
     *
     * @return JWSRenewalInfoDecodedPayload|null
     * @link https://developer.apple.com/documentation/appstoreservernotifications/jwsrenewalinfodecodedpayload
     */
    public function getDecodedRenewalInfo(): ?JWSRenewalInfoDecodedPayload
    {
        return \is_null($this->signedRenewalInfo) ? null : new JWSRenewalInfoDecodedPayload(
            Tools::decodeSignedString($this->signedRenewalInfo)
        );
    }

    /**
     * Get decoded transaction information.
     *
     * @return JWSTransactionDecodedPayload|null
     * @link https://developer.apple.com/documentation/appstoreservernotifications/jwstransactiondecodedpayload
     */
    public function getDecodedTransactionInfo(): ?JWSTransactionDecodedPayload
    {
        return \is_null($this->signedTransactionInfo) ? null : new JWSTransactionDecodedPayload(
            Tools::decodeSignedString($this->signedTransactionInfo)
        );
    }
}
