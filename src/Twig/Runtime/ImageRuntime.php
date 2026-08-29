<?php

declare(strict_types=1);

namespace Symfinity\OmniaIpsum\Twig\Runtime;

use Symfinity\OmniaIpsum\Service\ImageProviderManager;
use Twig\Extension\RuntimeExtensionInterface;

final class ImageRuntime implements RuntimeExtensionInterface
{
    public function __construct(
        private readonly ImageProviderManager $imageProviderManager,
    ) {
    }

    /**
     * Generate a placeholder image URL.
     *
     * @param array<string, mixed> $options
     */
    public function omniaImage(int $width, int $height, array $options = []): string
    {
        return $this->imageProviderManager->generate($width, $height, $options);
    }

    /**
     * Generate a placeholder avatar URL.
     *
     * @param array<string, mixed> $options
     */
    public function omniaAvatar(string $name, int $size = 100, array $options = []): string
    {
        return $this->imageProviderManager->generateAvatar($name, $size, $options);
    }
}
