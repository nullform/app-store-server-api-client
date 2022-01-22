<?php

namespace Nullform\AppStoreServerApiClient;

/**
 * Interface for App Store API keys.
 *
 * @link https://developer.apple.com/documentation/appstoreserverapi/creating_api_keys_to_use_with_the_app_store_server_api
 */
interface ApiKeyInterface
{
    /**
     * @return string
     */
    public function getPrivateKey(): string;

    /**
     * @param string $privateKey
     * @return $this
     */
    public function setPrivateKey(string $privateKey): self;

    /**
     * @return string
     */
    public function getPrivateKeyId(): string;

    /**
     * @param string $privateKeyId
     * @return $this
     */
    public function setPrivateKeyId(string $privateKeyId): self;

    /**
     * @return string
     */
    public function getIssuerId(): string;

    /**
     * @param string $issuerId
     * @return $this
     */
    public function setIssuerId(string $issuerId): self;

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
