<?php

namespace Nullform\AppStoreServerApiClient\Tests;

use Firebase\JWT\JWT;
use Nullform\AppStoreServerApiClient\AbstractApiKey;
use Nullform\AppStoreServerApiClient\AbstractBundle;
use Nullform\AppStoreServerApiClient\AppStoreServerApiClient;
use Nullform\AppStoreServerApiClient\Environment;
use PHPUnit\Framework\TestCase;

abstract class AbstractTestCase extends TestCase
{
    protected $originalTransactionId = '';

    protected function getClient(): AppStoreServerApiClient
    {
        $apiKey = new class extends AbstractApiKey {
        };
        $apiKey->setPrivateKey($this->getCredentials()['appstore_key']);
        $apiKey->setPrivateKeyId($this->getCredentials()['appstore_key_id']);
        $apiKey->setIssuerId($this->getCredentials()['appstore_issuer_id']);

        $bundle = new class extends AbstractBundle {
        };
        $bundle->setBundleId($this->getCredentials()['appstore_bundle_id']);

        $this->originalTransactionId = $this->getCredentials()['original_transaction_id'];

        $client = new AppStoreServerApiClient($apiKey, $bundle, Environment::SANDBOX);

        $client->setHttpClientRequestTimeout(60);

        try {
            JWT::encode(['test'], $apiKey->getPrivateKey(), 'ES256', $apiKey->getPrivateKeyId());
        } catch (\Throwable $exception) {
            throw new \Exception("Can't encode data with your private key. Check it. " . $exception->getMessage());
        }

        return $client;
    }

    /**
     * @return array{
     *     appstore_bundle_id: string,
     *     appstore_issuer_id: string,
     *     appstore_key_id: string,
     *     appstore_key: string,
     *     original_transaction_id: string
     * }
     * @throws \Exception
     */
    protected function getCredentials(): array
    {
        if (\is_file(__DIR__ . DIRECTORY_SEPARATOR . 'credentials.local.php')) {
            $credentials = include __DIR__ . DIRECTORY_SEPARATOR . 'credentials.local.php';
        } elseif (\is_file(__DIR__ . DIRECTORY_SEPARATOR . 'credentials.php')) {
            $credentials = include __DIR__ . DIRECTORY_SEPARATOR . 'credentials.php';
        } else {
            throw new \Exception("Can't load credentials file");
        }

        foreach ($credentials as $key => $value) {
            if (empty($value)) {
                throw new \Exception("Empty value in credentials: " . \htmlspecialchars($key));
            }
        }

        return $credentials;
    }
}
