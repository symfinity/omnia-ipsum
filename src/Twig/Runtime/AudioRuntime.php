<?php

declare(strict_types=1);

namespace Symfinity\OmniaIpsum\Twig\Runtime;

use Symfinity\OmniaIpsum\Service\AudioProviderManager;
use Twig\Extension\RuntimeExtensionInterface;

final class AudioRuntime implements RuntimeExtensionInterface
{
    public function __construct(
        private readonly AudioProviderManager $audioProviderManager,
    ) {
    }

    /**
     * Generate a placeholder audio URL or data URL.
     *
     * @param array<string, mixed> $options
     */
    public function omniaAudio(int $duration, array $options = []): string
    {
        return $this->audioProviderManager->generate($duration, $options);
    }
}
