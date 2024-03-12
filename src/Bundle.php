<?php

namespace Nullform\AppStoreServerApiClient;

/**
 * App Store bundle.
 */
class Bundle extends AbstractBundle
{
    /**
     * @param string $bundleId
     * @param string $name
     */
    public function __construct(string $bundleId, string $name = '')
    {
        $this->setBundleId($bundleId);
        $this->setName($name);
    }
}
