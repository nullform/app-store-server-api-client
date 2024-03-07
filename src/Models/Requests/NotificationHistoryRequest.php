<?php

namespace Nullform\AppStoreServerApiClient\Models\Requests;

use Nullform\AppStoreServerApiClient\AbstractModel;
use Nullform\AppStoreServerApiClient\NotificationV2Subtypes;
use Nullform\AppStoreServerApiClient\NotificationV2Types;

/**
 * The request body for notification history.
 *
 * @link https://developer.apple.com/documentation/appstoreserverapi/notificationhistoryrequest
 */
class NotificationHistoryRequest extends AbstractModel
{
    /**
     * Required. The start date of the timespan for the requested App Store Server Notification history records.
     * The startDate needs to precede the endDate.
     * Choose a startDate that’s within the past 180 days from the current date.
     *
     * @var int
     * @link https://developer.apple.com/documentation/appstoreserverapi/startdate
     */
    public $startDate;

    /**
     * Required. The end date of the timespan for the requested App Store Server Notification history records.
     * Choose an endDate that’s later than the startDate.
     * If you choose an endDate in the future, the endpoint automatically uses the current date as the endDate.
     *
     * @var int
     * @link https://developer.apple.com/documentation/appstoreserverapi/enddate
     */
    public $endDate;

    /**
     * Optional. A notification type. Provide this field to limit the notification history records to those
     * with this one notification type.
     *
     * Note: You may include either the transactionId or the notificationType property (or neither) in your query,
     * but not both.
     *
     * @var null|string
     * @link https://developer.apple.com/documentation/appstoreserverapi/notificationtype
     * @see NotificationV2Types
     */
    public $notificationType = null;

    /**
     * Optional. A notification subtype. Provide this field to limit the notification history records to those
     * with this one notification subtype.
     *
     * If you specify a notificationSubtype, you need to also specify its related notificationType.
     *
     * @var null|string
     * @link https://developer.apple.com/documentation/appstoreserverapi/notificationsubtype
     * @see NotificationV2Subtypes
     */
    public $notificationSubtype = null;

    /**
     * Optional. A Boolean value you set to true to request only the notifications that haven’t reached your
     * server successfully.
     *
     * The response also includes notifications that the App Store server is currently retrying to send to your server.
     *
     * @var null|bool
     * @link https://developer.apple.com/documentation/appstoreserverapi/onlyfailures
     */
    public $onlyFailures = null;

    /**
     * Optional. The transaction identifier, which may be an original transaction identifier, of any transaction
     * belonging to the customer.
     * Provide this field to limit the notification history request to this one customer.
     *
     * Note: You may include either the transactionId or the notificationType property (or neither) in your query,
     * but not both.
     *
     * @var null|string
     * @link https://developer.apple.com/documentation/appstoreserverapi/transactionid
     */
    public $transactionId = null;
}
