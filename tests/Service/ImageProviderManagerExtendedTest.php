<?php

declare(strict_types=1);

namespace Symfinity\OmniaIpsum\Tests\Service;

use Symfinity\OmniaIpsum\Provider\ImageProviderInterface;
use Symfinity\OmniaIpsum\Service\ImageProviderManager;
use PHPUnit\Framework\TestCase;

final class ImageProviderManagerExtendedTest extends TestCase
{
    private ImageProviderManager $manager;

    protected function setUp(): void
    {
        $config = [
            'images' => [
                'default_provider' => 'placeholder',
                'default_width' => 600,
                'default_height' => 400,
                'default_background' => 'cccccc',
                'default_foreground' => '333333',
            ],
        ];

        $this->manager = new ImageProviderManager($config);
    }

    public function testGenerateAvatarWithShortName(): void
    {
        $url = $this->manager->generateAvatar('John', 100);

        $this->assertIsString($url);
        $this->assertStringContainsString('ui-avatars.com', $url);
        $this->assertStringContainsString('John', $url);
    }

    public function testGenerateAvatarWithLongName(): void
    {
        $url = $this->manager->generateAvatar('John Michael Smith', 100);

        $this->assertIsString($url);
        $this->assertStringContainsString('ui-avatars.com', $url);
        $this->assertStringContainsString('John+Michael+Smith', $url);
    }

    public function testGenerateAvatarWithEmptyName(): void
    {
        $url = $this->manager->generateAvatar('', 100);

        $this->assertIsString($url);
        $this->assertStringContainsString('ui-avatars.com', $url);
    }

    public function testGenerateAvatarWithCustomColors(): void
    {
        $url = $this->manager->generateAvatar('Test', 100, [
            'background' => 'ff0000',
            'foreground' => '000000',
        ]);

        $this->assertIsString($url);
        $this->assertStringContainsString('ff0000', $url);
        $this->assertStringContainsString('000000', $url);
    }

    public function testGenerateWithUnsupportedOptions(): void
    {
        // Options that provider doesn't support should be filtered out
        $url = $this->manager->generate(600, 400, [
            'provider' => 'placeholder',
            'background' => 'cccccc',
            'unsupported_option' => 'value',
        ]);

        $this->assertIsString($url);
        // Should still generate valid URL
        $this->assertStringContainsString('https://', $url);
    }

    public function testRegisterCustomProvider(): void
    {
        $customProvider = new class implements ImageProviderInterface {
            public function generate(int $width, int $height, array $options = []): string
            {
                return sprintf('https://custom.test/%dx%d', $width, $height);
            }

            public function getName(): string
            {
                return 'custom';
            }

            public function supportsOption(string $option): bool
            {
                return false;
            }
        };

        $this->manager->registerProvider($customProvider);

        $provider = $this->manager->getProvider('custom');
        $this->assertSame('custom', $provider->getName());

        $url = $this->manager->generate(600, 400, ['provider' => 'custom']);
        $this->assertStringContainsString('https://custom.test/600x400', $url);
    }

    public function testGetAllProviders(): void
    {
        $providers = $this->manager->getProviders();

        $this->assertIsArray($providers);
        $this->assertArrayHasKey('placeholder', $providers);
        $this->assertArrayHasKey('dummyimage', $providers);
        $this->assertArrayHasKey('picsum', $providers);
        $this->assertArrayHasKey('placehold', $providers);
        $this->assertArrayHasKey('ui-avatars', $providers);

        $this->assertCount(5, $providers);
    }

    public function testGenerateWithAllProviders(): void
    {
        $providers = ['placeholder', 'dummyimage', 'picsum', 'placehold', 'ui-avatars'];

        foreach ($providers as $providerName) {
            $url = $this->manager->generate(600, 400, ['provider' => $providerName]);

            $this->assertIsString($url);
            $this->assertStringContainsString('https://', $url);
        }
    }

    public function testGenerateUsesDefaultProvider(): void
    {
        $url = $this->manager->generate(600, 400);

        // Should use default provider (placeholder)
        $this->assertStringContainsString('placeholder.com', $url);
    }
}
