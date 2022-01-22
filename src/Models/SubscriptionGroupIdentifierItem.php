<?php

namespace Nullform\AppStoreServerApiClient\Models;

use Nullform\AppStoreServerApiClient\AbstractModel;

/**
 * Subscription information, including signed transaction information and signed renewal information,
 * for one subscription group.
 *
 * @link https://developer.apple.com/documentation/appstoreserverapi/subscriptiongroupidentifieritem
 */
class SubscriptionGroupIdentifierItem extends AbstractModel
{
    /**
     * The subscription group identifier of the subscriptions in the lastTransactions array.
     *
     * @var string
     * @link https://developer.apple.com/documentation/appstoreserverapi/subscriptiongroupidentifier
     */
    public $subscriptionGroupIdentifier;

    /**
     * An array of the most recent signed transaction information and signed renewal information for all subscriptions
     * in the subscription group.
     *
     * @var LastTransactionsItem[]
     */
    public $lastTransactions = [];

    /**
     * @inheritDoc
     */
    public function map(array $data): AbstractModel
    {
        parent::map($data);

        $this->lastTransactions = [];

        if (!empty($data['lastTransactions']) && \is_array($data['lastTransactions'])) {
            foreach ($data['lastTransactions'] as $_transaction) {
                $this->lastTransactions[] = new LastTransactionsItem($_transaction);
            }
        }

        return $this;
    }
}
