<?php

namespace Nullform\AppStoreServerApiClient\Models;

use Nullform\AppStoreServerApiClient\AbstractModel;
use Nullform\AppStoreServerApiClient\Tools;

/**
 * The most recent signed transaction information and signed renewal information for a subscription.
 *
 * @link https://developer.apple.com/documentation/appstoreserverapi/lasttransactionsitem
 */
class LastTransactionsItem extends AbstractModel
{
    /**
     * The original transaction identifier of the subscription.
     *
     * @var string
     * @link https://developer.apple.com/documentation/appstoreserverapi/originaltransactionid
     */
    public $originalTransactionId;

    /**
     * The status of the subscription.
     *
     * - 1: The subscription is active.
     * - 2: The subscription is expired.
     * - 3: The subscription is in a billing retry period.
     * - 4: The subscription is in a billing grace period.
     * - 5: The subscription is revoked.
     *
     * @var int
     * @link https://developer.apple.com/documentation/appstoreserverapi/status
     */
    public $status;

    /**
     * The subscription renewal information signed by Apple, in JSON Web Signature (JWS) format.
     *
     * @var string
     * @link https://developer.apple.com/documentation/appstoreserverapi/jwsrenewalinfo
     */
    public $signedRenewalInfo = '';

    /**
     * The transaction information signed by Apple, in JWS format.
     *
     * @var string
     * @link https://developer.apple.com/documentation/appstoreserverapi/jwstransaction
     */
    public $signedTransactionInfo = '';

    /**
     * Get decoded subscription renewal information.
     *
     * @return JWSRenewalInfoDecodedPayload
     * @link https://developer.apple.com/documentation/appstoreserverapi/jwsrenewalinfodecodedpayload
     */
    public function getDecodedRenewalInfo(): JWSRenewalInfoDecodedPayload
    {
        return new JWSRenewalInfoDecodedPayload(
            Tools::decodeSignedString($this->signedRenewalInfo)
        );
    }

    /**
     * Get decoded transaction information.
     *
     * @return JWSTransactionDecodedPayload
     * @link https://developer.apple.com/documentation/appstoreserverapi/jwstransactiondecodedpayload
     */
    public function getDecodedTransactionInfo(): JWSTransactionDecodedPayload
    {
        return new JWSTransactionDecodedPayload(
            Tools::decodeSignedString($this->signedTransactionInfo)
        );
    }
}
