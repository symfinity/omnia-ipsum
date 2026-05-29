<?php

declare(strict_types=1);

namespace Symfinity\OmniaIpsum\Tests\Service;

use Symfinity\OmniaIpsum\Service\FakerFactory;
use PHPUnit\Framework\TestCase;

final class FakerFactoryExtendedTest extends TestCase
{
    public function testCreateWithSeed(): void
    {
        $config = [
            'faker' => [
                'locale' => 'en_US',
                'seed' => 42,
            ],
        ];

        $factory = new FakerFactory($config);

        // Same seed should produce same results
        $faker1 = $factory->create();
        $name1 = $faker1->name();

        $factory2 = new FakerFactory($config);
        $faker2 = $factory2->create();
        $name2 = $faker2->name();

        $this->assertSame($name1, $name2);
    }

    public function testCreateWithDifferentLocales(): void
    {
        $locales = ['en_US', 'de_DE', 'fr_FR', 'es_ES'];

        foreach ($locales as $locale) {
            $config = [
                'faker' => [
                    'locale' => $locale,
                    'seed' => null,
                ],
            ];

            $factory = new FakerFactory($config);
            $faker = $factory->create(); // Use default from config

            $this->assertSame($locale, $factory->getLocale());
        }
    }

    public function testFakeWithDifferentFormatters(): void
    {
        $config = [
            'faker' => [
                'locale' => 'en_US',
                'seed' => null,
            ],
        ];

        $factory = new FakerFactory($config);

        // Test various formatters
        $name = $factory->fake('name');
        $this->assertIsString($name);
        $this->assertNotEmpty($name);

        $email = $factory->fake('email');
        $this->assertIsString($email);
        $this->assertStringContainsString('@', $email);

        $number = $factory->fake('randomNumber');
        $this->assertIsInt($number);

        $boolean = $factory->fake('boolean');
        $this->assertIsBool($boolean);
    }

    public function testFakeWithArguments(): void
    {
        $config = [
            'faker' => [
                'locale' => 'en_US',
                'seed' => null,
            ],
        ];

        $factory = new FakerFactory($config);

        // Test formatter with arguments
        $number = $factory->fake('numberBetween', [1, 100]);
        $this->assertIsInt($number);
        $this->assertGreaterThanOrEqual(1, $number);
        $this->assertLessThanOrEqual(100, $number);

        $text = $factory->fake('text', [50]);
        $this->assertIsString($text);
        $this->assertLessThanOrEqual(60, \strlen($text)); // Approximate
    }

    public function testCreateReusesInstance(): void
    {
        $config = [
            'faker' => [
                'locale' => 'en_US',
                'seed' => null,
            ],
        ];

        $factory = new FakerFactory($config);

        $faker1 = $factory->create();
        $faker2 = $factory->create(); // No locale specified, should use default

        // Should reuse same instance for default locale
        $this->assertSame($faker1, $faker2);
        $this->assertSame('en_US', $factory->getLocale());
    }

    public function testCreateDifferentInstancesForDifferentLocales(): void
    {
        $config = [
            'faker' => [
                'locale' => 'en_US',
                'seed' => null,
            ],
        ];

        $factory = new FakerFactory($config);

        $fakerEN = $factory->create(); // Default locale
        $localeEN = $factory->getLocale();

        $fakerDE = $factory->create('de_DE'); // Explicit different locale
        $localeDE = $factory->getLocale();

        $this->assertNotSame($fakerEN, $fakerDE);
        $this->assertSame('en_US', $localeEN);
        $this->assertSame('de_DE', $localeDE);
    }

    public function testFakeWithCommonFormatters(): void
    {
        $config = [
            'faker' => [
                'locale' => 'en_US',
                'seed' => null,
            ],
        ];

        $factory = new FakerFactory($config);

        $formatters = [
            'name',
            'firstName',
            'lastName',
            'email',
            'phoneNumber',
            'address',
            'city',
            'country',
            'company',
            'jobTitle',
            'url',
            'userName',
            'date',
            'sentence',
            'paragraph',
        ];

        foreach ($formatters as $formatter) {
            $result = $factory->fake($formatter);
            $this->assertNotNull($result);
        }
    }
}
