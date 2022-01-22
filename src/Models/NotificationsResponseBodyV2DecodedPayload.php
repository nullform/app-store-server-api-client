<?php

namespace Nullform\AppStoreServerApiClient\Models;

use Nullform\AppStoreServerApiClient\AbstractModel;
use Nullform\AppStoreServerApiClient\NotificationV2Subtypes;
use Nullform\AppStoreServerApiClient\NotificationV2Types;

/**
 * A decoded payload containing the version 2 notification data.
 *
 * @link https://developer.apple.com/documentation/appstoreservernotifications/responsebodyv2decodedpayload
 */
class NotificationsResponseBodyV2DecodedPayload extends AbstractModel
{
    /**
     * The in-app purchase event for which the App Store sent this version 2 notification.
     *
     * @var string
     * @link https://developer.apple.com/documentation/appstoreservernotifications/notificationtype
     * @see NotificationV2Types
     */
    public $notificationType;

    /**
     * Additional information that identifies the notification event, or an empty string.
     * The subtype applies only to select version 2 notifications.
     *
     * @var string
     * @link https://developer.apple.com/documentation/appstoreservernotifications/subtype
     * @see NotificationV2Subtypes
     */
    public $subtype;

    /**
     * A unique identifier for the notification. Use this value to identify a duplicate notification.
     *
     * @var string
     * @link https://developer.apple.com/documentation/appstoreservernotifications/notificationuuid
     */
    public $notificationUUID;

    /**
     * The version number of the notification.
     *
     * @var string
     * @link https://developer.apple.com/documentation/appstoreservernotifications/notificationversion
     */
    public $notificationVersion;

    /**
     * The object that contains the app metadata and signed renewal and transaction information.
     *
     * @var NotificationsResponseBodyV2DecodedPayloadData
     * @link https://developer.apple.com/documentation/appstoreservernotifications/data
     */
    public $data;

    /**
     * @inheritDoc
     */
    public function map(array $data): AbstractModel
    {
        parent::map($data);

        if (!empty($data['data'])) {
            $this->data = new NotificationsResponseBodyV2DecodedPayloadData($data['data']);
        }

        return $this;
    }
}
