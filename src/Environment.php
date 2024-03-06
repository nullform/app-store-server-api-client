<?php

namespace Nullform\AppStoreServerApiClient;

/**
 * Environment for Apple App Store Server API.
 */
class Environment
{
    /**
     * Sansbox environment.
     */
    public const SANDBOX = 'sandbox';

    /**
     * Production environment.
     */
    public const PRODUCTION = 'production';

    /**
     * @var string
     */
    protected $environment;

    /**
     * @var string
     * @deprecated
     */
    protected $version;

    /**
     * @param string $environment
     * @see Environment::SANDBOX
     * @see Environment::PRODUCTION
     */
    public function __construct(string $environment)
    {
        $this->environment = $environment;
    }

    /**
     * Current environment.
     *
     * @return string
     * @see Environment::SANDBOX
     * @see Environment::PRODUCTION
     */
    public function getEnvironment(): string
    {
        return $this->environment;
    }

    /**
     * @return string
     * @deprecated
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * Get base URL for API endpoints dependent on environment.
     *
     * @return string
     */
    public function getBaseUrl(): string
    {
        switch ($this->environment) {
            default:
                $url = "https://api.storekit.itunes.apple.com/";
            break;
            case static::SANDBOX:
                $url = "https://api.storekit-sandbox.itunes.apple.com/";
            break;
        }
        return $url;
    }
}
