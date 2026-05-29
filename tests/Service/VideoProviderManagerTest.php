<?php

declare(strict_types=1);

namespace Symfinity\OmniaIpsum\Tests\Service;

use Symfinity\OmniaIpsum\Service\VideoProviderManager;
use PHPUnit\Framework\TestCase;

final class VideoProviderManagerTest extends TestCase
{
    private VideoProviderManager $manager;

    protected function setUp(): void
    {
        $config = [
            'videos' => [
                'default_provider' => 'gcs',
                'default_width' => 1920,
                'default_height' => 1080,
                'default_duration' => 30,
            ],
        ];

        $this->manager = new VideoProviderManager($config);
    }

    public function testGenerate(): void
    {
        $url = $this->manager->generate(1920, 1080);

        $this->assertIsString($url);
        $this->assertStringContainsString('https://', $url);
        $this->assertStringContainsString('commondatastorage.googleapis.com', $url);
    }

    public function testGenerateWithVideo(): void
    {
        $url = $this->manager->generate(1920, 1080, ['video' => 'sintel']);

        $this->assertStringContainsString('Sintel.mp4', $url);
    }

    public function testGetProvider(): void
    {
        $provider = $this->manager->getProvider('gcs');

        $this->assertSame('gcs', $provider->getName());
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
        $this->assertArrayHasKey('gcs', $providers);
        $this->assertCount(1, $providers);
    }

    public function testGenerateUsesDefaultProvider(): void
    {
        $url = $this->manager->generate(1920, 1080);

        $this->assertStringContainsString('commondatastorage.googleapis.com', $url);
    }

    public function testGenerateWithUnsupportedOptions(): void
    {
        // Options that provider doesn't support should be filtered out
        $url = $this->manager->generate(1920, 1080, [
            'video' => 'sintel',
            'unsupported' => 'option',
        ]);

        $this->assertStringContainsString('Sintel.mp4', $url);
    }
}
