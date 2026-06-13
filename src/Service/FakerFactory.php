<?php

declare(strict_types=1);

namespace Symfinity\OmniaIpsum\Service;

use Faker\Factory;
use Faker\Generator;
use Symfinity\OmniaIpsum\Util\ConfigAccess;

/**
 * Factory for creating Faker instances with configured locale and seed.
 */
final class FakerFactory
{
    private ?Generator $faker = null;
    private ?string $currentLocale = null;

    /**
     * @param array<string, mixed> $config
     */
    public function __construct(private readonly array $config)
    {
    }

    /**
     * Get or create a Faker instance.
     */
    public function create(?string $locale = null): Generator
    {
        $locale ??= $this->getDefaultLocale();

        // Always create a new instance for different locales
        // Don't cache when locale is explicitly provided
        if ($locale !== $this->getDefaultLocale() || null === $this->faker) {
            $faker = Factory::create($locale);
            $this->currentLocale = $locale;

            // Set seed if configured (only for default locale)
            if ($locale === $this->getDefaultLocale()) {
                $seed = $this->getConfiguredSeed();
                if (null !== $seed) {
                    $faker->seed($seed);
                }
            }

            // Only cache default locale instance
            if ($locale === $this->getDefaultLocale()) {
                $this->faker = $faker;
            }

            return $faker;
        }

        return $this->faker;
    }

    /**
     * Get the current locale.
     */
    public function getLocale(): string
    {
        return $this->currentLocale ?? $this->getDefaultLocale();
    }

    /**
     * Generate fake data using Faker.
     *
     * @param array<int, mixed> $arguments
     */
    public function fake(string $formatter, array $arguments = []): mixed
    {
        $faker = $this->create();

        // Faker uses magic methods, so we can't check with method_exists
        // Just try to call it and let Faker handle invalid formatters
        try {
            return $faker->format($formatter, $arguments);
        } catch (\InvalidArgumentException $e) {
            throw new \InvalidArgumentException(sprintf('Faker formatter "%s" does not exist.', $formatter), 0, $e);
        }
    }

    private function getDefaultLocale(): string
    {
        return ConfigAccess::sectionString($this->config, 'faker', 'locale', 'en_US');
    }

    private function getConfiguredSeed(): ?int
    {
        $fakerConfig = ConfigAccess::section($this->config, 'faker');

        return ConfigAccess::nullableInt($fakerConfig, 'seed');
    }
}
