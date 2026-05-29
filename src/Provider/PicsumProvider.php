<?php

declare(strict_types=1);

namespace Symfinity\OmniaIpsum\Provider;

/**
 * Picsum Photos provider (Lorem Picsum).
 *
 * @see https://picsum.photos
 */
final class PicsumProvider implements ImageProviderInterface
{
    public function generate(int $width, int $height, array $options = []): string
    {
        $grayscale = $options['grayscale'] ?? false;
        $blur = $options['blur'] ?? null;
        $seed = $options['seed'] ?? null;

        $url = sprintf('https://picsum.photos/%d/%d', $width, $height);

        $params = [];
        if (true === $grayscale) {
            $params[] = 'grayscale';
        }

        if (null !== $blur) {
            $params[] = 'blur=' . (int) $blur;
        }

        if (null !== $seed) {
            $params[] = 'random=' . (int) $seed;
        }

        if ([] !== $params) {
            $url .= '?' . implode('&', $params);
        }

        return $url;
    }

    public function getName(): string
    {
        return 'picsum';
    }

    public function supportsOption(string $option): bool
    {
        return \in_array($option, ['grayscale', 'blur', 'seed'], true);
    }
}
