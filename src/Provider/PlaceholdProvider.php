<?php

declare(strict_types=1);

namespace Symfinity\OmniaIpsum\Provider;

/**
 * Placehold.co provider.
 *
 * @see https://placehold.co
 */
final class PlaceholdProvider implements ImageProviderInterface
{
    public function generate(int $width, int $height, array $options = []): string
    {
        $background = $options['background'] ?? 'cccccc';
        $foreground = $options['foreground'] ?? '333333';
        $text = $options['text'] ?? null;
        $format = $options['format'] ?? 'png';

        $background = ltrim($background, '#');
        $foreground = ltrim($foreground, '#');

        $url = sprintf('https://placehold.co/%dx%d/%s/%s.%s', $width, $height, $background, $foreground, $format);

        if (null !== $text) {
            $url .= '?text=' . urlencode((string) $text);
        }

        return $url;
    }

    public function getName(): string
    {
        return 'placehold';
    }

    public function supportsOption(string $option): bool
    {
        return \in_array($option, ['background', 'foreground', 'text', 'format'], true);
    }
}
