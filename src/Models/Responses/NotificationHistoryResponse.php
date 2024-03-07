<?php

namespace Nullform\AppStoreServerApiClient\Models\Responses;

use Nullform\AppStoreServerApiClient\AbstractModel;
use Nullform\AppStoreServerApiClient\Models\NotificationHistoryResponseItem;

/**
 * A response that contains the App Store Server Notifications history for your app.
 *
 * @link https://developer.apple.com/documentation/appstoreserverapi/notificationhistoryresponse
 */
class NotificationHistoryResponse extends AbstractModel
{
    /**
     * An array of App Store Server Notifications history records.
     *
     * @var NotificationHistoryResponseItem[]
     * @link https://developer.apple.com/documentation/appstoreserverapi/notificationhistoryresponseitem
     */
    public $notificationHistory = [];

    /**
     * A Boolean value that indicates whether the App Store has more notification history records to send.
     * If hasMore is true, use the paginationToken in the subsequent request to get more records.
     * If hasMore is false, there are no more records available.
     *
     * @var bool
     * @link https://developer.apple.com/documentation/appstoreserverapi/hasmore
     */
    public $hasMore;

    /**
     * A pagination token that you provide on a subsequent request to get the next page of responses.
     *
     * @var string
     * @link https://developer.apple.com/documentation/appstoreserverapi/paginationtoken?changes=latest_major
     */
    public $paginationToken;

    /**
     * @inheritDoc
     */
    public function map(array $data): AbstractModel
    {
        parent::map($data);

        $this->notificationHistory = [];

        if (!empty($data['notificationHistory']) && \is_array($data['notificationHistory'])) {
            foreach ($data['notificationHistory'] as $_row) {
                $this->notificationHistory[] = new NotificationHistoryResponseItem($_row);
            }
        }

        return $this;
    }
}
