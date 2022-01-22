<?php

namespace Nullform\AppStoreServerApiClient\Models\Responses;

use Nullform\AppStoreServerApiClient\Models\JWSTransactionDecodedPayload;
use Nullform\AppStoreServerApiClient\Tools;

trait SignedTransactionsTrait
{
    /**
     * Transaction information, signed by the App Store, in JSON Web Signature format.
     *
     * @var string[]
     * @link https://developer.apple.com/documentation/appstoreserverapi/jwstransaction
     */
    public $signedTransactions = [];

    /**
     * @return JWSTransactionDecodedPayload[]
     * @link https://developer.apple.com/documentation/appstoreserverapi/jwstransactiondecodedpayload
     */
    public function getDecodedTransactions(): array
    {
        $decodedTransactions = [];
        if (\property_exists($this, 'signedTransactions') && !empty($this->signedTransactions)) {
            foreach ($this->signedTransactions as $signedTransaction) {
                $decodedTransactions[] = new JWSTransactionDecodedPayload(
                    Tools::decodeSignedString($signedTransaction)
                );
            }
        }
        return $decodedTransactions;
    }
}
