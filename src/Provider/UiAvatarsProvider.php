<?php

declare(strict_types=1);

namespace Symfinity\OmniaIpsum\Provider;

/**
 * UI Avatars provider for avatar generation.
 *
 * @see https://ui-avatars.com
 */
final class UiAvatarsProvider implements ImageProviderInterface
{
    public function generate(int $width, int $height, array $options = []): string
    {
        $name = $options['name'] ?? '??';
        $background = $options['background'] ?? null;
        $color = $options['foreground'] ?? 'ffffff';
        $bold = $options['bold'] ?? false;
        $rounded = $options['rounded'] ?? false;

        // UI Avatars uses size (not width/height), take the smaller dimension
        $size = min($width, $height);

        $params = [
            'name' => $name,
            'size' => $size,
            'color' => ltrim($color, '#'),
        ];

        if (null !== $background) {
            $params['background'] = ltrim((string) $background, '#');
        }

        if ($bold) {
            $params['bold'] = 'true';
        }

        if ($rounded) {
            $params['rounded'] = 'true';
        }

        return 'https://ui-avatars.com/api/?' . http_build_query($params);
    }

    public function getName(): string
    {
        return 'ui-avatars';
    }

    public function supportsOption(string $option): bool
    {
        return \in_array($option, ['name', 'background', 'foreground', 'bold', 'rounded'], true);
    }
}
