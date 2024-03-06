<?php

namespace Nullform\AppStoreServerApiClient\Models\Responses;

use Nullform\AppStoreServerApiClient\AbstractModel;

/**
 * A response that contains an array of signed JSON Web Signature (JWS) transactions.
 *
 * @link https://developer.apple.com/documentation/appstoreserverapi/refundlookupresponse
 * @deprecated Used for backward compatibility as a base class.
 */
class RefundLookupResponse extends AbstractModel
{
    use SignedTransactionsTrait;
}
