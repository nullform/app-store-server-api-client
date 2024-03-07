<?php

namespace Nullform\AppStoreServerApiClient\Models;

use Nullform\AppStoreServerApiClient\AbstractModel;
use Nullform\AppStoreServerApiClient\AppStoreServerApiClient;
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
     * @var string|null
     * @link https://developer.apple.com/documentation/appstoreservernotifications/subtype
     * @see NotificationV2Subtypes
     */
    public $subtype = null;

    /**
     * The object that contains the app metadata and signed renewal and transaction information.
     *
     * The data, summary, and externalPurchaseToken fields are mutually exclusive. The payload contains only one of
     * these fields.
     *
     * @var null|NotificationsResponseBodyV2DecodedPayloadData
     * @link https://developer.apple.com/documentation/appstoreservernotifications/data
     */
    public $data = null;

    /**
     * The summary data that appears when the App Store server completes your request to extend a subscription renewal
     * date for eligible subscribers.
     * For more information, see:
     * https://developer.apple.com/documentation/appstoreserverapi/extend_subscription_renewal_dates_for_all_active_subscribers.
     *
     * The data, summary, and externalPurchaseToken fields are mutually exclusive. The payload contains only one of
     * these fields.
     *
     * @var null|NotificationsResponseBodyV2DecodedPayloadSummary
     * @link https://developer.apple.com/documentation/appstoreservernotifications/summary
     * @see AppStoreServerApiClient::extendSubscriptionRenewalDatesForAllActiveSubscribers()
     */
    public $summary = null;

    /**
     * This field appears when the notificationType is EXTERNAL_PURCHASE_TOKEN.
     *
     * The data, summary, and externalPurchaseToken fields are mutually exclusive. The payload contains only one of
     * these fields.
     *
     * @var null|NotificationsResponseBodyV2DecodedPayloadExternalPurchaseToken
     * @link https://developer.apple.com/documentation/appstoreservernotifications/externalpurchasetoken
     */
    public $externalPurchaseToken = null;

    /**
     * The App Store Server Notification version number, "2.0".
     *
     * @var string
     * @link https://developer.apple.com/documentation/appstoreservernotifications/version
     */
    public $version;

    /**
     * The UNIX time, in milliseconds, that the App Store signed the JSON Web Signature data.
     *
     * @var int
     * @link https://developer.apple.com/documentation/appstoreservernotifications/signeddate
     */
    public $signedDate;

    /**
     * A unique identifier for the notification. Use this value to identify a duplicate notification.
     *
     * @var string
     * @link https://developer.apple.com/documentation/appstoreservernotifications/notificationuuid
     */
    public $notificationUUID;

    /**
     * Deprecated.
     * The version number of the notification.
     *
     * @var string|null
     * @deprecated
     * @see NotificationsResponseBodyV2DecodedPayload::$version
     */
    public $notificationVersion;

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
