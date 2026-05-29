<?php

declare(strict_types=1);

namespace Symfinity\OmniaIpsum\Service;

use Symfinity\OmniaIpsum\Provider\GoogleCloudStorageVideoProvider;
use Symfinity\OmniaIpsum\Provider\VideoProviderInterface;

final class VideoProviderManager
{
    /** @var array<string, VideoProviderInterface> */
    private array $providers = [];

    /**
     * @param array<string, mixed> $config
     */
    public function __construct(private readonly array $config)
    {
        $this->registerDefaultProviders();
    }

    /**
     * Generate a placeholder video URL.
     *
     * @param array<string, mixed> $options
     */
    public function generate(int $width, int $height, array $options = []): string
    {
        $providerName = $options['provider'] ?? ($this->config['videos']['default_provider'] ?? 'gcs');

        $provider = $this->getProvider($providerName);

        // Filter options to only those supported by the provider
        $supportedOptions = [];
        foreach ($options as $key => $value) {
            if ($provider->supportsOption($key)) {
                $supportedOptions[$key] = $value;
            }
        }

        return $provider->generate($width, $height, $supportedOptions);
    }

    /**
     * Register a video provider.
     */
    public function registerProvider(VideoProviderInterface $provider): void
    {
        $this->providers[$provider->getName()] = $provider;
    }

    /**
     * Get a registered provider by name.
     */
    public function getProvider(string $name): VideoProviderInterface
    {
        if (!isset($this->providers[$name])) {
            throw new \InvalidArgumentException(sprintf('Video provider "%s" not found.', $name));
        }

        return $this->providers[$name];
    }

    /**
     * Get all registered providers.
     *
     * @return array<string, VideoProviderInterface>
     */
    public function getProviders(): array
    {
        return $this->providers;
    }

    private function registerDefaultProviders(): void
    {
        $this->registerProvider(new GoogleCloudStorageVideoProvider());
    }
}
