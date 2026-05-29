<?php

declare(strict_types=1);

namespace Symfinity\OmniaIpsum\Tests\Service;

use Symfinity\OmniaIpsum\Service\AudioProviderManager;
use PHPUnit\Framework\TestCase;

final class AudioProviderManagerTest extends TestCase
{
    private AudioProviderManager $manager;

    protected function setUp(): void
    {
        $config = [
            'audios' => [
                'default_provider' => 'silence',
                'default_duration' => 10,
            ],
        ];

        $this->manager = new AudioProviderManager($config);
    }

    public function testGenerate(): void
    {
        $url = $this->manager->generate(10);

        $this->assertIsString($url);
        $this->assertStringStartsWith('data:audio/wav;base64,', $url);
    }

    public function testGenerateWithProvider(): void
    {
        $url = $this->manager->generate(10, ['provider' => 'silence']);

        $this->assertStringStartsWith('data:audio/wav;base64,', $url);
    }

    public function testGenerateWithOptions(): void
    {
        $url = $this->manager->generate(10, [
            'sample_rate' => 48000,
            'channels' => 2,
        ]);

        $this->assertIsString($url);
        $this->assertStringStartsWith('data:audio/wav;base64,', $url);
    }

    public function testGetProvider(): void
    {
        $provider = $this->manager->getProvider('silence');

        $this->assertSame('silence', $provider->getName());
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
        $this->assertArrayHasKey('silence', $providers);
        $this->assertCount(1, $providers);
    }

    public function testGenerateUsesDefaultProvider(): void
    {
        $url = $this->manager->generate(10);

        // Should use default provider (silence)
        $this->assertStringStartsWith('data:audio/wav;base64,', $url);
    }

    public function testGenerateWithUnsupportedOptions(): void
    {
        // Options that provider doesn't support should be filtered out
        $url = $this->manager->generate(10, [
            'provider' => 'silence',
            'sample_rate' => 44100,
            'unsupported_option' => 'value',
        ]);

        $this->assertIsString($url);
        $this->assertStringStartsWith('data:audio/wav;base64,', $url);
    }

    public function testGenerateWithDifferentDurations(): void
    {
        $url1 = $this->manager->generate(1);
        $url10 = $this->manager->generate(10);
        $url30 = $this->manager->generate(30);

        $this->assertIsString($url1);
        $this->assertIsString($url10);
        $this->assertIsString($url30);

        // Longer duration = longer data URL
        $this->assertLessThan(\strlen($url10), \strlen($url1));
        $this->assertLessThan(\strlen($url30), \strlen($url10));
    }
}
