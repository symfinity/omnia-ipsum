<?php

declare(strict_types=1);

namespace Symfinity\OmniaIpsum\Tests\Provider;

use Symfinity\OmniaIpsum\Provider\GoogleCloudStorageVideoProvider;
use PHPUnit\Framework\TestCase;

final class GoogleCloudStorageVideoProviderTest extends TestCase
{
    private GoogleCloudStorageVideoProvider $provider;

    protected function setUp(): void
    {
        $this->provider = new GoogleCloudStorageVideoProvider();
    }

    public function testGenerate(): void
    {
        $url = $this->provider->generate(1920, 1080);

        $this->assertStringContainsString('commondatastorage.googleapis.com', $url);
        $this->assertStringContainsString('.mp4', $url);
    }

    public function testGenerateWithVideo(): void
    {
        $url = $this->provider->generate(1920, 1080, ['video' => 'sintel']);

        $this->assertStringContainsString('Sintel.mp4', $url);
    }

    public function testGenerateDefaultsToBigBuckBunny(): void
    {
        $url = $this->provider->generate(1920, 1080);

        $this->assertStringContainsString('BigBuckBunny.mp4', $url);
    }

    public function testGenerateWithInvalidVideoFallsBackToDefault(): void
    {
        $url = $this->provider->generate(1920, 1080, ['video' => 'invalid-video']);

        $this->assertStringContainsString('BigBuckBunny.mp4', $url);
    }

    public function testGetName(): void
    {
        $this->assertSame('gcs', $this->provider->getName());
    }

    public function testSupportsOption(): void
    {
        $this->assertTrue($this->provider->supportsOption('video'));
        $this->assertFalse($this->provider->supportsOption('duration'));
        $this->assertFalse($this->provider->supportsOption('fps'));
    }

    public function testGetAvailableVideos(): void
    {
        $videos = GoogleCloudStorageVideoProvider::getAvailableVideos();

        $this->assertIsArray($videos);
        $this->assertContains('big-buck-bunny', $videos);
        $this->assertContains('sintel', $videos);
        $this->assertContains('elephants-dream', $videos);
        $this->assertGreaterThan(10, \count($videos));
    }
}
