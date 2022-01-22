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
     */
    protected $version;

    /**
     * @param string $environment
     * @param string $version
     * @see SANDBOX
     * @see PRODUCTION
     */
    public function __construct(string $environment, string $version = '1')
    {
        $this->environment = $environment;
        $this->version = $version;
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
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * Get base URL for API endpoints dependent on environment and API version.
     *
     * @return string
     */
    public function getBaseUrl(): string
    {
        switch ($this->environment) {
            default:
                $url = "https://api.storekit.itunes.apple.com/inApps/v{$this->version}/";
            break;
            case static::SANDBOX:
                $url = "https://api.storekit-sandbox.itunes.apple.com/inApps/v{$this->version}/";
            break;
        }
        return $url;
    }
}
