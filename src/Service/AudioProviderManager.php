<?php

declare(strict_types=1);

namespace Symfinity\OmniaIpsum\Service;

use Symfinity\OmniaIpsum\Provider\AudioProviderInterface;
use Symfinity\OmniaIpsum\Provider\SilenceAudioProvider;
use Symfinity\OmniaIpsum\Util\ConfigAccess;

final class AudioProviderManager
{
    /** @var array<string, AudioProviderInterface> */
    private array $providers = [];

    /**
     * @param array<string, mixed> $config
     */
    public function __construct(private readonly array $config)
    {
        $this->registerDefaultProviders();
    }

    /**
     * Generate a placeholder audio URL or data URL.
     *
     * @param array<string, mixed> $options
     */
    public function generate(int $duration, array $options = []): string
    {
        $providerName = ConfigAccess::nullableString($options, 'provider')
            ?? ConfigAccess::sectionString($this->config, 'audios', 'default_provider', 'silence');

        $provider = $this->getProvider($providerName);

        // Filter options to only those supported by the provider
        $filteredOptions = array_filter(
            $options,
            fn ($key) => 'provider' !== $key && $provider->supportsOption($key),
            \ARRAY_FILTER_USE_KEY
        );

        return $provider->generate($duration, $filteredOptions);
    }

    /**
     * Register a custom audio provider.
     */
    public function registerProvider(AudioProviderInterface $provider): void
    {
        $this->providers[$provider->getName()] = $provider;
    }

    /**
     * Get a provider by name.
     */
    public function getProvider(string $name): AudioProviderInterface
    {
        if (!isset($this->providers[$name])) {
            throw new \InvalidArgumentException(sprintf('Audio provider "%s" not found.', $name));
        }

        return $this->providers[$name];
    }

    /**
     * Get all registered providers.
     *
     * @return array<string, AudioProviderInterface>
     */
    public function getProviders(): array
    {
        return $this->providers;
    }

    private function registerDefaultProviders(): void
    {
        $this->registerProvider(new SilenceAudioProvider());
    }
}
