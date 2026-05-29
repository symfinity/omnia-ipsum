<?php

declare(strict_types=1);

namespace Symfinity\OmniaIpsum\Tests\Service;

use Symfinity\OmniaIpsum\Service\ImageProviderManager;
use PHPUnit\Framework\TestCase;

final class ImageProviderManagerTest extends TestCase
{
    private ImageProviderManager $manager;

    protected function setUp(): void
    {
        $config = [
            'images' => [
                'default_provider' => 'placeholder',
                'default_width' => 600,
                'default_height' => 400,
            ],
        ];

        $this->manager = new ImageProviderManager($config);
    }

    public function testGenerate(): void
    {
        $url = $this->manager->generate(600, 400);

        $this->assertIsString($url);
        $this->assertStringContainsString('https://', $url);
    }

    public function testGenerateWithProvider(): void
    {
        $url = $this->manager->generate(600, 400, ['provider' => 'picsum']);

        $this->assertStringContainsString('picsum.photos', $url);
    }

    public function testGenerateAvatar(): void
    {
        $url = $this->manager->generateAvatar('John Doe', 100);

        $this->assertIsString($url);
        $this->assertStringContainsString('https://ui-avatars.com', $url);
        $this->assertStringContainsString('John+Doe', $url);
    }

    public function testGetProvider(): void
    {
        $provider = $this->manager->getProvider('placeholder');

        $this->assertSame('placeholder', $provider->getName());
    }

    public function testGetProviderThrowsException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->manager->getProvider('invalid-provider');
    }

    public function testGetProviders(): void
    {
        $providers = $this->manager->getProviders();

        $this->assertIsArray($providers);
        $this->assertArrayHasKey('placeholder', $providers);
        $this->assertArrayHasKey('picsum', $providers);
        $this->assertArrayHasKey('ui-avatars', $providers);
        $this->assertCount(5, $providers);
    }
}
