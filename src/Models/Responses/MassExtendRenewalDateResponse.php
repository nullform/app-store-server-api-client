<?php

namespace Nullform\AppStoreServerApiClient\Models\Responses;

use Nullform\AppStoreServerApiClient\AbstractModel;

/**
 * A response that indicates the server successfully received the subscription-renewal-date extension request.
 *
 * @link https://developer.apple.com/documentation/appstoreserverapi/massextendrenewaldateresponse
 */
class MassExtendRenewalDateResponse extends AbstractModel
{
    /**
     * A string that contains the UUID that identifies the subscription-renewal-date extension request.
     *
     * Maximum Length: 128
     *
     * @var string
     * @link https://developer.apple.com/documentation/appstoreserverapi/requestidentifier
     */
    public $requestIdentifier;
}
