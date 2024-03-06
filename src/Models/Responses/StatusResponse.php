<?php

namespace Nullform\AppStoreServerApiClient\Models\Responses;

use Nullform\AppStoreServerApiClient\AbstractModel;
use Nullform\AppStoreServerApiClient\Models\SubscriptionGroupIdentifierItem;

/**
 * A response that contains status information for all of a customer’s subscriptions in your app.
 *
 * @link https://developer.apple.com/documentation/appstoreserverapi/statusresponse
 */
class StatusResponse extends AbstractModel
{
    /**
     * An array of subscription information, including signed transaction information and signed renewal information.
     *
     * @var SubscriptionGroupIdentifierItem[]
     * @link https://developer.apple.com/documentation/appstoreserverapi/subscriptiongroupidentifieritem
     */
    public $data = [];

    /**
     * The server environment, sandbox or production, in which the App Store generated the response.
     *
     * @var string
     * @link https://developer.apple.com/documentation/appstoreserverapi/environment
     */
    public $environment;

    /**
     * Your app’s App Store identifier.
     *
     * @var int|null
     * @link https://developer.apple.com/documentation/appstoreserverapi/appappleid
     */
    public $appAppleId;

    /**
     * Your app’s bundle identifier.
     *
     * @var string
     * @link https://developer.apple.com/documentation/appstoreserverapi/bundleid
     */
    public $bundleId;

    /**
     * @inheritDoc
     */
    public function map(array $data): AbstractModel
    {
        parent::map($data);

        $this->data = [];

        if (!empty($data['data']) && is_array($data['data'])) {
            foreach ($data['data'] as $_row) {
                $this->data[] = new SubscriptionGroupIdentifierItem($_row);
            }
        }

        return $this;
    }
}
