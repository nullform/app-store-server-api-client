<?php

namespace Nullform\AppStoreServerApiClient\Models\Responses;

use Nullform\AppStoreServerApiClient\AbstractModel;
use Nullform\AppStoreServerApiClient\Models\NotificationsResponseBodyV2DecodedPayload;
use Nullform\AppStoreServerApiClient\Models\SendAttemptItem;
use Nullform\AppStoreServerApiClient\Tools;

/**
 * A response that contains the contents of the App Store server's test notification and the result from your server.
 *
 * @link https://developer.apple.com/documentation/appstoreserverapi/checktestnotificationresponse
 */
class CheckTestNotificationResponse extends AbstractModel
{
    /**
     * An array of information the App Store server records for its attempts to send the TEST notification to your
     * server. The array may contain a maximum of six sendAttemptItem objects.
     *
     * @var SendAttemptItem[]
     * @link https://developer.apple.com/documentation/appstoreserverapi/sendattemptitem
     */
    public $sendAttempts = [];

    /**
     * The signed payload, in JWS format, that contains the TEST notification that the App Store server sent to your
     * server.
     *
     * @var string
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
