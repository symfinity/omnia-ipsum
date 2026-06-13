<?php

declare(strict_types=1);

namespace Symfinity\OmniaIpsum\Provider;

use Symfinity\OmniaIpsum\Util\ConfigAccess;

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
        $blur = ConfigAccess::nullableInt($options, 'blur');
        $seed = ConfigAccess::nullableInt($options, 'seed');

        $url = sprintf('https://picsum.photos/%d/%d', $width, $height);

        $params = [];
        if (true === $grayscale) {
            $params[] = 'grayscale';
        }

        if (null !== $blur) {
            $params[] = 'blur=' . $blur;
        }

        if (null !== $seed) {
            $params[] = 'random=' . $seed;
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
