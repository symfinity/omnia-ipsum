<?php

declare(strict_types=1);

namespace Symfinity\OmniaIpsum\Service;

use Symfinity\OmniaIpsum\Provider\DummyImageProvider;
use Symfinity\OmniaIpsum\Provider\ImageProviderInterface;
use Symfinity\OmniaIpsum\Provider\PicsumProvider;
use Symfinity\OmniaIpsum\Provider\PlaceholderProvider;
use Symfinity\OmniaIpsum\Provider\PlaceholdProvider;
use Symfinity\OmniaIpsum\Provider\UiAvatarsProvider;
use Symfinity\OmniaIpsum\Util\ConfigAccess;

final class ImageProviderManager
{
    /** @var array<string, ImageProviderInterface> */
    private array $providers = [];

    /**
     * @param array<string, mixed> $config
     */
    public function __construct(private readonly array $config)
    {
        $this->registerDefaultProviders();
    }

    /**
     * Generate a placeholder image URL.
     *
     * @param array<string, mixed> $options
     */
    public function generate(int $width, int $height, array $options = []): string
    {
        $providerName = ConfigAccess::nullableString($options, 'provider')
            ?? ConfigAccess::sectionString($this->config, 'images', 'default_provider', 'placeholder');

        $provider = $this->getProvider($providerName);

        // Filter options to only those supported by the provider
        $filteredOptions = array_filter(
            $options,
            fn ($key) => 'provider' !== $key && $provider->supportsOption($key),
            \ARRAY_FILTER_USE_KEY
        );

        return $provider->generate($width, $height, $filteredOptions);
    }

    /**
     * Generate an avatar URL.
     *
     * @param array<string, mixed> $options
     */
    public function generateAvatar(string $name, int $size = 100, array $options = []): string
    {
        $background = $options['background'] ?? $this->generateColorFromName($name);
        $foreground = $options['foreground'] ?? 'ffffff';
        $bold = $options['bold'] ?? false;
        $rounded = $options['rounded'] ?? false;

        // Use UI Avatars for better avatar generation
        $provider = $this->getProvider('ui-avatars');

        return $provider->generate($size, $size, [
            'name' => $name,
            'background' => $background,
            'foreground' => $foreground,
            'bold' => $bold,
            'rounded' => $rounded,
        ]);
    }

    /**
     * Register a custom image provider.
     */
    public function registerProvider(ImageProviderInterface $provider): void
    {
        $this->providers[$provider->getName()] = $provider;
    }

    /**
     * Get a provider by name.
     */
    public function getProvider(string $name): ImageProviderInterface
    {
        if (!isset($this->providers[$name])) {
            throw new \InvalidArgumentException(sprintf('Image provider "%s" not found.', $name));
        }

        return $this->providers[$name];
    }

    /**
     * Get all registered providers.
     *
     * @return array<string, ImageProviderInterface>
     */
    public function getProviders(): array
    {
        return $this->providers;
    }

    private function registerDefaultProviders(): void
    {
        $this->registerProvider(new PlaceholderProvider());
        $this->registerProvider(new DummyImageProvider());
        $this->registerProvider(new PicsumProvider());
        $this->registerProvider(new PlaceholdProvider());
        $this->registerProvider(new UiAvatarsProvider());
    }

    private function generateColorFromName(string $name): string
    {
        // Generate a consistent color from the name
        $hash = md5($name);

        return substr($hash, 0, 6);
    }
}
