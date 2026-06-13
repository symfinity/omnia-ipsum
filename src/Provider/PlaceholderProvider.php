<?php

declare(strict_types=1);

namespace Symfinity\OmniaIpsum\Provider;

use Symfinity\OmniaIpsum\Util\ConfigAccess;

/**
 * Placeholder.com provider.
 *
 * @see https://placeholder.com
 */
final class PlaceholderProvider implements ImageProviderInterface
{
    public function generate(int $width, int $height, array $options = []): string
    {
        $background = ltrim(ConfigAccess::string($options, 'background', 'cccccc'), '#');
        $foreground = ltrim(ConfigAccess::string($options, 'foreground', '333333'), '#');
        $text = ConfigAccess::nullableString($options, 'text');

        $url = sprintf('https://via.placeholder.com/%dx%d/%s/%s', $width, $height, $background, $foreground);

        if (null !== $text) {
            $url .= '?text=' . urlencode($text);
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
