<?php

namespace Nullform\AppStoreServerApiClient\Models\Responses;

use Nullform\AppStoreServerApiClient\AbstractModel;

/**
 * A response that contains the test notification token.
 *
 * @link https://developer.apple.com/documentation/appstoreserverapi/sendtestnotificationresponse
 */
class SendTestNotificationResponse extends AbstractModel
{
    /**
     * The test notification token that uniquely identifies the notification test that
     * App Store Server Notifications sends to your server.
     *
     * @var string
     * @link https://developer.apple.com/documentation/appstoreserverapi/testnotificationtoken
     */
    public $testNotificationToken;
}
