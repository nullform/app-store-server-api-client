<?php

namespace Nullform\AppStoreServerApiClient\Models;

use Nullform\AppStoreServerApiClient\AbstractModel;
use Nullform\AppStoreServerApiClient\Tools;

/**
 * The App Store server notification history record, including the signed notification payload and the result of
 * the server’s first send attempt.
 *
 * @link https://developer.apple.com/documentation/appstoreserverapi/notificationhistoryresponseitem
 */
class NotificationHistoryResponseItem extends AbstractModel
{
    /**
     * An array of information the App Store server records for its attempts to send a notification to your server.
     * The maximum number of entries in the array is six.
     *
     * @var SendAttemptItem[]
     * @link https://developer.apple.com/documentation/appstoreserverapi/sendattemptitem
     */
    public $sendAttempts = [];

    /**
     * The cryptographically signed payload, in JSON Web Signature (JWS) format, containing the original response body
     * of a version 2 notification.
     *
     * @var string
     * @link https://developer.apple.com/documentation/appstoreserverapi/signedpayload
     */
    public $signedPayload;

    /**
     * @inheritDoc
     */
    public function map(array $data): AbstractModel
    {
        parent::map($data);

        $this->sendAttempts = [];

        if (!empty($data['sendAttempts']) && \is_array($data['sendAttempts'])) {
            foreach ($data['sendAttempts'] as $_row) {
                $this->sendAttempts[] = new SendAttemptItem($_row);
            }
        }

        return $this;
    }

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
