<?php

declare(strict_types=1);

namespace Symfinity\OmniaIpsum\Provider;

interface ImageProviderInterface
{
    /**
     * Generate a placeholder image URL.
     *
     * @param array<string, mixed> $options
     */
    public function generate(int $width, int $height, array $options = []): string;

    /**
     * Get the provider name.
     */
    public function getName(): string;

    /**
     * Check if the provider supports a specific option.
     */
    public function supportsOption(string $option): bool;
}
