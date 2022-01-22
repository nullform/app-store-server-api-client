<?php

namespace Nullform\AppStoreServerApiClient;

/**
 * Interface for App Store bundles.
 *
 * @link https://developer.apple.com/documentation/appstoreserverapi/generating_tokens_for_api_requests
 */
interface BundleInterface
{
    /**
     * @return string
     */
    public function getBundleId(): string;

    /**
     * @param string $bundleId
     * @return $this
     */
    public function setBundleId(string $bundleId): self;

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name): self;
}
