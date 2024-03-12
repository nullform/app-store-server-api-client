<?php

namespace Nullform\AppStoreServerApiClient;

/**
 * Basic abstract class for App Store API keys.
 *
 * @link https://developer.apple.com/documentation/appstoreserverapi/creating_api_keys_to_use_with_the_app_store_server_api
 */
abstract class AbstractApiKey implements ApiKeyInterface
{
    /**
     * @var string
     */
    protected $privateKey = '';

    /**
     * @var string
     */
    protected $privateKeyId = '';

    /**
     * @var string
     */
    protected $issuerId = '';

    /**
     * @var string
     */
    protected $name = '';

    /**
     * @inheritDoc
     */
    public function getPrivateKey(): string
    {
        return $this->privateKey;
    }

    /**
     * @inheritDoc
     */
    public function setPrivateKey(string $privateKey): ApiKeyInterface
    {
        $this->privateKey = $privateKey;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getPrivateKeyId(): string
    {
        return $this->privateKeyId;
    }

    /**
     * @inheritDoc
     */
    public function setPrivateKeyId(string $privateKeyId): ApiKeyInterface
    {
        $this->privateKeyId = $privateKeyId;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getIssuerId(): string
    {
        return $this->issuerId;
    }

    /**
     * @inheritDoc
     */
    public function setIssuerId(string $issuerId): ApiKeyInterface
    {
        $this->issuerId = $issuerId;

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
    public function setName(string $name): ApiKeyInterface
    {
        $this->name = $name;

        return $this;
    }
}
