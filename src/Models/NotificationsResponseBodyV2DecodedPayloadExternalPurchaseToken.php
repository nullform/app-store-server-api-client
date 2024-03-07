<?php

namespace Nullform\AppStoreServerApiClient\Models;

use Nullform\AppStoreServerApiClient\AbstractModel;

/**
 * The payload data that contains an external purchase token.
 *
 * @link https://developer.apple.com/documentation/appstoreservernotifications/externalpurchasetoken
 */
class NotificationsResponseBodyV2DecodedPayloadExternalPurchaseToken extends AbstractModel
{
    /**
     * The unique identifier of the token.
     *
     * Use this value to report tokens and their associated transactions in the "Send External Purchase Report"
     * endpoint: https://developer.apple.com/documentation/externalpurchaseserverapi/send-external-purchase-report
     *
     * @var string
     * @link https://developer.apple.com/documentation/appstoreservernotifications/externalpurchaseid
     * @todo Link to future client method
     */
    public $externalPurchaseId;

    /**
     * The UNIX time, in milliseconds, when the system created the token.
     *
     * @var int
     * @link https://developer.apple.com/documentation/appstoreservernotifications/tokencreationdate
     */
    public $tokenCreationDate;

    /**
     * The app Apple ID for which the system generated the token.
     *
     * @var int|null
     */
    public $appAppleId;

    /**
     * The bundle ID of the app for which the system generated the token.
     *
     * @var string
     */
    public $bundleId;
}
