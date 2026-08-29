<?php

declare(strict_types=1);

namespace Symfinity\OmniaIpsum\Tests\Integration;

use Symfinity\OmniaIpsum\Service\AudioProviderManager;
use Symfinity\OmniaIpsum\Service\ImageProviderManager;
use Symfinity\OmniaIpsum\Service\ProviderHealthChecker;
use Symfinity\OmniaIpsum\Service\VideoProviderManager;
use PHPUnit\Framework\TestCase;

final class ProviderHealthCheckerTest extends TestCase
{
    private ProviderHealthChecker $healthChecker;

    protected function setUp(): void
    {
        $config = [
            'images' => ['default_provider' => 'picsum'],
            'videos' => ['default_provider' => 'gcs'],
            'audios' => ['default_provider' => 'silence'],
        ];

        $imageManager = new ImageProviderManager($config);
        $videoManager = new VideoProviderManager($config);
        $audioManager = new AudioProviderManager($config);

        $this->healthChecker = new ProviderHealthChecker($imageManager, $videoManager, $audioManager);
    }

    public function testCheckImageProvider(): void
    {
        // Test with a known provider
        $result = $this->healthChecker->checkImageProvider('picsum', 5);

        // Result can be true or false depending on network availability
        $this->assertIsBool($result);
    }

    public function testCheckVideoProvider(): void
    {
        $result = $this->healthChecker->checkVideoProvider('gcs', 5);

        $this->assertIsBool($result);
    }

    public function testCheckAudioProvider(): void
    {
        // Silence provider should always be healthy (data URL)
        $silenceResult = $this->healthChecker->checkAudioProvider('silence', 5);

        $this->assertTrue($silenceResult);
    }

    public function testCheckAllImageProviders(): void
    {
        $results = $this->healthChecker->checkAllImageProviders(5);

        $this->assertIsArray($results);
        $this->assertNotEmpty($results);

        foreach ($results as $providerName => $isHealthy) {
            $this->assertIsString($providerName);
            $this->assertIsBool($isHealthy);
        }
    }

    public function testCheckAllVideoProviders(): void
    {
        $results = $this->healthChecker->checkAllVideoProviders(5);

        $this->assertIsArray($results);
        $this->assertNotEmpty($results);

        foreach ($results as $providerName => $isHealthy) {
            $this->assertIsString($providerName);
            $this->assertIsBool($isHealthy);
        }
    }

    public function testCheckAllAudioProviders(): void
    {
        $results = $this->healthChecker->checkAllAudioProviders(5);

        $this->assertIsArray($results);
        $this->assertNotEmpty($results);

        foreach ($results as $providerName => $isHealthy) {
            $this->assertIsString($providerName);
            $this->assertIsBool($isHealthy);
        }
    }

    public function testCheckAllProviders(): void
    {
        $results = $this->healthChecker->checkAllProviders(5);

        $this->assertIsArray($results);
        $this->assertArrayHasKey('images', $results);
        $this->assertArrayHasKey('videos', $results);
        $this->assertArrayHasKey('audios', $results);

        $this->assertIsArray($results['images']);
        $this->assertIsArray($results['videos']);
        $this->assertIsArray($results['audios']);
    }

    public function testCache(): void
    {
        // First check should populate cache
        $result1 = $this->healthChecker->checkImageProvider('picsum', 5);

        // Second check should use cache (same result)
        $result2 = $this->healthChecker->checkImageProvider('picsum', 5);

        $this->assertSame($result1, $result2);

        // Clear cache
        $this->healthChecker->clearCache();

        // After clearing, should check again (might be different due to network)
        $result3 = $this->healthChecker->checkImageProvider('picsum', 5);

        $this->assertIsBool($result3);
    }

    public function testInvalidProvider(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Image provider "invalid-provider" not found.');

        $this->healthChecker->checkImageProvider('invalid-provider', 5);
    }
}
