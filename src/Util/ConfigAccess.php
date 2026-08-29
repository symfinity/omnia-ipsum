<?php

declare(strict_types=1);

namespace Symfinity\OmniaIpsum\Util;

final class ConfigAccess
{
    /**
     * @param array<string, mixed> $data
     */
    public static function string(array $data, string $key, string $default): string
    {
        $value = $data[$key] ?? $default;

        return \is_string($value) ? $value : $default;
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function nullableString(array $data, string $key): ?string
    {
        $value = $data[$key] ?? null;

        return \is_string($value) ? $value : null;
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function nullableInt(array $data, string $key): ?int
    {
        $value = $data[$key] ?? null;

        if (\is_int($value)) {
            return $value;
        }

        if (\is_string($value) && ctype_digit($value)) {
            return (int) $value;
        }

        return null;
    }

    /**
     * @param array<string, mixed> $config
     */
    public static function sectionString(array $config, string $section, string $key, string $default): string
    {
        $sectionData = $config[$section] ?? null;
        if (!\is_array($sectionData)) {
            return $default;
        }

        /** @var array<string, mixed> $sectionData */
        return self::string($sectionData, $key, $default);
    }

    /**
     * @param array<string, mixed> $config
     *
     * @return array<string, mixed>
     */
    public static function section(array $config, string $section): array
    {
        $sectionData = $config[$section] ?? null;

        if (!\is_array($sectionData)) {
            return [];
        }

        /** @var array<string, mixed> $normalized */
        $normalized = [];
        foreach ($sectionData as $key => $value) {
            if (\is_string($key)) {
                $normalized[$key] = $value;
            }
        }

        return $normalized;
    }
}
