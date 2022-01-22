<?php

namespace Nullform\AppStoreServerApiClient\Models\Responses;

use Nullform\AppStoreServerApiClient\AbstractModel;
use Nullform\AppStoreServerApiClient\Models\NotificationsResponseBodyV2DecodedPayload;
use Nullform\AppStoreServerApiClient\Tools;

/**
 * The response body the App Store sends in a version 2 server notification.
 *
 * @link https://developer.apple.com/documentation/appstoreservernotifications/responsebodyv2
 */
class NotificationsResponseBodyV2 extends AbstractModel
{
    /**
     * The payload in JSON Web Signature (JWS) format, signed by the App Store.
     *
     * @var string
     * @link https://developer.apple.com/documentation/appstoreservernotifications/signedpayload
     */
    public $signedPayload;

    /**
     * Get decoded notification payload.
     *
     * @return NotificationsResponseBodyV2DecodedPayload
     */
    public function getDecodedPayload(): NotificationsResponseBodyV2DecodedPayload
    {
        return new NotificationsResponseBodyV2DecodedPayload(
            Tools::decodeSignedString($this->signedPayload)
        );
    }
}
