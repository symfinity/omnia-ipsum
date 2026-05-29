<?php

declare(strict_types=1);

namespace Symfinity\OmniaIpsum\Provider;

/**
 * Placeholder.com provider.
 *
 * @see https://placeholder.com
 */
final class PlaceholderProvider implements ImageProviderInterface
{
    public function generate(int $width, int $height, array $options = []): string
    {
        $background = $options['background'] ?? 'cccccc';
        $foreground = $options['foreground'] ?? '333333';
        $text = $options['text'] ?? null;

        $background = ltrim($background, '#');
        $foreground = ltrim($foreground, '#');

        $url = sprintf('https://via.placeholder.com/%dx%d/%s/%s', $width, $height, $background, $foreground);

        if (null !== $text) {
            $url .= '?text=' . urlencode((string) $text);
        }

        return $url;
    }

    public function getName(): string
    {
        return 'placeholder';
    }

    public function supportsOption(string $option): bool
    {
        return \in_array($option, ['background', 'foreground', 'text'], true);
    }
}
