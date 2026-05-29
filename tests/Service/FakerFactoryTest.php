<?php

declare(strict_types=1);

namespace Symfinity\OmniaIpsum\Tests\Service;

use Symfinity\OmniaIpsum\Service\FakerFactory;
use PHPUnit\Framework\TestCase;

final class FakerFactoryTest extends TestCase
{
    private FakerFactory $factory;

    protected function setUp(): void
    {
        $config = [
            'faker' => [
                'locale' => 'en_US',
                'seed' => null,
            ],
        ];

        $this->factory = new FakerFactory($config);
    }

    public function testCreate(): void
    {
        $faker = $this->factory->create();

        $this->assertSame('en_US', $this->factory->getLocale());
    }

    public function testCreateWithCustomLocale(): void
    {
        $faker = $this->factory->create('de_DE');

        $this->assertSame('de_DE', $this->factory->getLocale());
    }

    public function testFake(): void
    {
        $name = $this->factory->fake('name');

        $this->assertIsString($name);
        $this->assertNotEmpty($name);
    }

    public function testFakeWithInvalidFormatter(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->factory->fake('invalid_formatter');
    }

    public function testFakeEmail(): void
    {
        $email = $this->factory->fake('email');

        $this->assertIsString($email);
        $this->assertStringContainsString('@', $email);
    }
}
