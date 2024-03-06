<?php

namespace Nullform\AppStoreServerApiClient\Models;

use Nullform\AppStoreServerApiClient\AbstractModel;

/**
 * The success or error information and the date the App Store server records when it attempts to send a server
 * notification to your server.
 *
 * @link https://developer.apple.com/documentation/appstoreserverapi/sendattemptitem
 */
class SendAttemptItem extends AbstractModel
{
    /**
     * The date the App Store server attempts to send the notification.
     *
     * @var int
     * @link https://developer.apple.com/documentation/appstoreserverapi/attemptdate
     */
    public $attemptDate;

    /**
     * The success or error information the App Store server records when it attempts to send an App Store server
     * notification to your server.
     *
     * - SUCCESS - The App Store server received a success response when it sent the notification to your server.
     * - CIRCULAR_REDIRECT - The App Store server detected a continual redirect. Check your server’s redirects for a circular redirect loop.
     * - INVALID_RESPONSE - The App Store server received an invalid response from your server.
     * - NO_RESPONSE - The App Store server didn’t receive a valid HTTP response from your server.
     * - OTHER - Another error occurred that prevented your server from receiving the notification.
     * - PREMATURE_CLOSE - The App Store server’s connection to your server was closed while the send was in progress.
     * - SOCKET_ISSUE - A network error caused the notification attempt to fail.
     * - TIMED_OUT - The App Store server didn’t get a response from your server and timed out. Check that your server isn’t processing messages in line.
     * - TLS_ISSUE - The App Store server couldn’t establish a TLS session or validate your certificate. Check that your server has a valid certificate and supports Transport Layer Security (TLS) protocol 1.2 or later.
     * - UNSUCCESSFUL_HTTP_RESPONSE_CODE - The App Store server didn’t receive an HTTP 200 response from your server.
     * - UNSUPPORTED_CHARSET - The App Store server doesn’t support the supplied charset.
     *
     * @var string
     * @link https://developer.apple.com/documentation/appstoreserverapi/sendattemptresult
     */
    public $sendAttemptResult;
}
