<?php

namespace Nullform\AppStoreServerApiClient;

use Nullform\AppStoreServerApiClient\Exceptions\NotificationBadRequestException;
use Nullform\AppStoreServerApiClient\Models\NotificationsResponseBodyV2DecodedPayload;
use Nullform\AppStoreServerApiClient\Models\Responses\NotificationsResponseBodyV2;

/**
 * Client for App Store Server Notifications.
 *
 * Usage:
 *
 * ```
 * $notificationClient = new AppStoreServerNotificationsClient();
 *
 * try {
 *     $payload = $notificationClient->recieve($requestBody);
 * } catch (NotificationBadRequestException $exception) {
 *     echo $exception->getMessage();
 * }
 * ```
 *
 * @link https://developer.apple.com/documentation/appstoreservernotifications
 */
class AppStoreServerNotificationsClient
{
    /**
     * Receive App Store server notification.
     *
     * @param string $body Request body.
     * @return NotificationsResponseBodyV2DecodedPayload
     * @throws NotificationBadRequestException
     */
    public function receive(string $body): NotificationsResponseBodyV2DecodedPayload
    {
        $responseBody = new NotificationsResponseBodyV2($body);

        if (empty($responseBody->signedPayload)) {
            throw new NotificationBadRequestException('Incorrect notification body');
        }

        return $responseBody->getDecodedPayload();
    }
}
