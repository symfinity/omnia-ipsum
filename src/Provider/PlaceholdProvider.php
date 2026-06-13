<?php

declare(strict_types=1);

namespace Symfinity\OmniaIpsum\Provider;

use Symfinity\OmniaIpsum\Util\ConfigAccess;

/**
 * Placehold.co provider.
 *
 * @see https://placehold.co
 */
final class PlaceholdProvider implements ImageProviderInterface
{
    public function generate(int $width, int $height, array $options = []): string
    {
        $background = ltrim(ConfigAccess::string($options, 'background', 'cccccc'), '#');
        $foreground = ltrim(ConfigAccess::string($options, 'foreground', '333333'), '#');
        $text = ConfigAccess::nullableString($options, 'text');
        $format = ConfigAccess::string($options, 'format', 'png');

        $url = sprintf('https://placehold.co/%dx%d/%s/%s.%s', $width, $height, $background, $foreground, $format);

        if (null !== $text) {
            $url .= '?text=' . urlencode($text);
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
