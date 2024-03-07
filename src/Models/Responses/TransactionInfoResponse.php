<?php

namespace Nullform\AppStoreServerApiClient\Models\Responses;

use Nullform\AppStoreServerApiClient\AbstractModel;
use Nullform\AppStoreServerApiClient\Models\JWSTransactionDecodedPayload;
use Nullform\AppStoreServerApiClient\Tools;

/**
 * A response that contains signed transaction information for a single transaction.
 *
 * @link https://developer.apple.com/documentation/appstoreserverapi/transactioninforesponse
 */
class TransactionInfoResponse extends AbstractModel
{
    /**
     * A customer’s in-app purchase transaction, signed by Apple, in JSON Web Signature (JWS) format.
     *
     * @var string
     */
    public $signedTransactionInfo;

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
