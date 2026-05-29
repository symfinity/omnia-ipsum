<?php

declare(strict_types=1);

namespace Symfinity\OmniaIpsum\Provider;

/**
 * Interface for video placeholder providers.
 */
interface VideoProviderInterface
{
    /**
     * Generate a placeholder video URL.
     *
     * @param int $width Video width
     * @param int $height Video height
     * @param array<string, mixed> $options Additional options (provider-specific)
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
