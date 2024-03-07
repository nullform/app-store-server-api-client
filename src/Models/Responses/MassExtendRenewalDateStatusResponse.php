<?php

namespace Nullform\AppStoreServerApiClient\Models\Responses;

use Nullform\AppStoreServerApiClient\AbstractModel;

/**
 * A response that indicates the current status of a request to extend the subscription renewal date to all
 * eligible subscribers.
 *
 * @link https://developer.apple.com/documentation/appstoreserverapi/massextendrenewaldatestatusresponse
 */
class MassExtendRenewalDateStatusResponse extends AbstractModel
{
    /**
     * The UUID that represents your request for a subscription-renewal-date extension.
     *
     * Maximum Length: 128
     *
     * @var string
     * @link https://developer.apple.com/documentation/appstoreserverapi/requestidentifier
     */
    public $requestIdentifier;

    /**
     * A Boolean value that’s TRUE to indicate that the App Store completed your request to extend a subscription
     * renewal date for all eligible subscribers.
     *
     * The value is FALSE if the request is in progress.
     *
     * @var bool
     */
    public $complete;

    /**
     * The date that the App Store completes the request.
     *
     * @var null|int
     * @link https://developer.apple.com/documentation/appstoreserverapi/completedate
     */
    public $completeDate = null;

    /**
     * The final count of subscribers that fail to receive a subscription-renewal-date extension.
     *
     * Appears only if complete is TRUE.
     *
     * @var null|int
     * @link https://developer.apple.com/documentation/appstoreserverapi/failedcount
     */
    public $failedCount = null;

    /**
     * The final count of subscribers that successfully receive a subscription-renewal-date extension.
     *
     * Appears only if complete is TRUE.
     *
     * @var null|int
     * @link https://developer.apple.com/documentation/appstoreserverapi/succeededcount
     */
    public $succeededCount = null;
}
