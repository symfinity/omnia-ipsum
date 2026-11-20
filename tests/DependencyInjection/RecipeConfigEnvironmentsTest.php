<?php

declare(strict_types=1);

namespace Symfinity\OmniaIpsum\Tests\DependencyInjection;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Yaml\Yaml;

/**
 * The Flex recipe enables OmniaIpsumBundle in dev and test only and copies this file into the
 * application. Settings outside when@dev/when@test break the prod container ("There is no
 * extension able to load the configuration for symfinity_omnia_ipsum").
 */
final class RecipeConfigEnvironmentsTest extends TestCase
{
    #[Test]
    public function theCopiedConfigOnlyAppliesWhereTheBundleIsEnabled(): void
    {
        $config = Yaml::parseFile(\dirname(__DIR__, 2).'/config/packages/symfinity_omnia_ipsum.yaml');
        self::assertIsArray($config);

        self::assertSame(['when@dev', 'when@test'], array_keys($config));
        self::assertIsArray($config['when@dev']);
        self::assertArrayHasKey('symfinity_omnia_ipsum', $config['when@dev']);
        self::assertSame($config['when@dev'], $config['when@test']);
    }

    #[Test]
    public function theRecipeEnablesTheBundleInDevAndTestOnly(): void
    {
        $path = \dirname(__DIR__, 4).'/recipes/symfinity/omnia-ipsum/0.1/manifest.json';
        if (!is_file($path)) {
            self::markTestSkipped('Recipe sources live in the product monorepo, not in the split package.');
        }
        $manifest = json_decode((string) file_get_contents($path), true, 512, \JSON_THROW_ON_ERROR);
        self::assertIsArray($manifest);

        $bundles = $manifest['bundles'] ?? null;
        self::assertIsArray($bundles);
        self::assertSame(['dev', 'test'], $bundles['Symfinity\\OmniaIpsum\\OmniaIpsumBundle'] ?? null);
    }
}
