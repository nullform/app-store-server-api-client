<?php

namespace Nullform\AppStoreServerApiClient;

/**
 * Basic abstract class for App Store bundles.
 *
 * @link https://developer.apple.com/documentation/appstoreserverapi/generating_tokens_for_api_requests
 */
abstract class AbstractBundle implements BundleInterface
{
    /**
     * @var string
     */
    protected $bundleId = '';

    /**
     * @var string
     */
    protected $name = '';

    /**
     * @inheritDoc
     */
    public function getBundleId(): string
    {
        return $this->bundleId;
    }

    /**
     * @inheritDoc
     */
    public function setBundleId(string $bundleId): BundleInterface
    {
        $this->bundleId = $bundleId;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @inheritDoc
     */
    public function setName(string $name): BundleInterface
    {
        $this->name = $name;

        return $this;
    }
}
