<?php

declare(strict_types=1);

namespace Symfinity\OmniaIpsum\Provider;

interface AudioProviderInterface
{
    /**
     * Generate a placeholder audio URL or data URL.
     *
     * @param array<string, mixed> $options
     */
    public function generate(int $duration, array $options = []): string;

    /**
     * Get the provider name.
     */
    public function getName(): string;

    /**
     * Check if the provider supports a specific option.
     */
    public function supportsOption(string $option): bool;
}
