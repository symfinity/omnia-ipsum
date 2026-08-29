<?php

declare(strict_types=1);

namespace Symfinity\OmniaIpsum\Tests\Service;

use Symfinity\OmniaIpsum\Provider\ImageProviderInterface;
use Symfinity\OmniaIpsum\Service\ImageProviderManager;
use PHPUnit\Framework\TestCase;

final class ImageProviderManagerEdgeCasesTest extends TestCase
{
    private ImageProviderManager $manager;

    protected function setUp(): void
    {
        $config = [
            'images' => [
                'default_provider' => 'picsum',
                'default_width' => 600,
                'default_height' => 400,
            ],
        ];

        $this->manager = new ImageProviderManager($config);
    }

    public function testGenerateWithEmptyOptions(): void
    {
        $url = $this->manager->generate(800, 600, []);

        $this->assertIsString($url);
        $this->assertStringContainsString('https://', $url);
    }

    public function testGenerateWithNullProvider(): void
    {
        $url = $this->manager->generate(800, 600, ['provider' => null]);

        $this->assertIsString($url);
    }

    public function testGenerateWithUnsupportedOptions(): void
    {
        $url = $this->manager->generate(800, 600, [
            'provider' => 'picsum',
            'unsupported_option' => 'value',
            'another_bad_option' => 123,
        ]);

        $this->assertStringContainsString('picsum.photos', $url);
    }

    public function testGenerateAvatarWithEmptyOptions(): void
    {
        $url = $this->manager->generateAvatar('John Doe', 100, []);

        $this->assertIsString($url);
        $this->assertStringContainsString('ui-avatars.com', $url);
    }

    public function testGenerateAvatarWithSpecialCharacters(): void
    {
        $url = $this->manager->generateAvatar('Müller & Schmidt', 100);

        $this->assertIsString($url);
        $this->assertStringContainsString('ui-avatars.com', $url);
    }

    public function testGenerateAvatarWithEmptyName(): void
    {
        $url = $this->manager->generateAvatar('', 100);

        $this->assertIsString($url);
        $this->assertStringContainsString('ui-avatars.com', $url);
    }

    public function testRegisterProviderOverwritesExisting(): void
    {
        $mockProvider = new class implements ImageProviderInterface {
            public function generate(int $width, int $height, array $options = []): string
            {
                return 'https://mock.example.com/test.jpg';
            }

            public function getName(): string
            {
                return 'picsum'; // Same name as existing
            }

            public function supportsOption(string $option): bool
            {
                return false;
            }
        };

        $this->manager->registerProvider($mockProvider);
        $url = $this->manager->generate(100, 100, ['provider' => 'picsum']);

        $this->assertSame('https://mock.example.com/test.jpg', $url);
    }

    public function testGetProvidersReturnsAllRegistered(): void
    {
        $providers = $this->manager->getProviders();

        $this->assertIsArray($providers);
        $this->assertGreaterThan(0, \count($providers));

        foreach ($providers as $name => $provider) {
            $this->assertIsString($name);
            $this->assertInstanceOf(ImageProviderInterface::class, $provider);
        }
    }

    public function testGenerateWithExtremelyLargeDimensions(): void
    {
        $url = $this->manager->generate(5000, 5000);

        $this->assertIsString($url);
        $this->assertStringContainsString('5000', $url);
    }

    public function testGenerateWithSmallDimensions(): void
    {
        $url = $this->manager->generate(1, 1);

        $this->assertIsString($url);
    }
}
