<?php

namespace Nullform\AppStoreServerApiClient;

/**
 * App Store API key.
 */
class ApiKey extends AbstractApiKey
{
    /**
     * @param string $privateKey
     * @param string $privateKeyId
     * @param string $issuerId
     * @param string $name
     */
    public function __construct(string $privateKey, string $privateKeyId, string $issuerId, string $name = '')
    {
        $this->setPrivateKey($privateKey);
        $this->setPrivateKeyId($privateKeyId);
        $this->setIssuerId($issuerId);
        $this->setName($name);
    }
}
