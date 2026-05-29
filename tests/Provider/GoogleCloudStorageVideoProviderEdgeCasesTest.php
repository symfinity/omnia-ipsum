<?php

declare(strict_types=1);

namespace Symfinity\OmniaIpsum\Tests\Provider;

use Symfinity\OmniaIpsum\Provider\GoogleCloudStorageVideoProvider;
use PHPUnit\Framework\TestCase;

final class GoogleCloudStorageVideoProviderEdgeCasesTest extends TestCase
{
    private GoogleCloudStorageVideoProvider $provider;

    protected function setUp(): void
    {
        $this->provider = new GoogleCloudStorageVideoProvider();
    }

    public function testGenerateWithEmptyVideoOption(): void
    {
        $url = $this->provider->generate(1920, 1080, ['video' => '']);

        $this->assertStringContainsString('BigBuckBunny.mp4', $url);
    }

    public function testGenerateWithNullVideoOption(): void
    {
        $url = $this->provider->generate(1920, 1080, ['video' => null]);

        $this->assertStringContainsString('BigBuckBunny.mp4', $url);
    }

    public function testGenerateWithCaseSensitiveVideoName(): void
    {
        $url = $this->provider->generate(1920, 1080, ['video' => 'Big-Buck-Bunny']);

        // Should fallback to default
        $this->assertStringContainsString('BigBuckBunny.mp4', $url);
    }

    public function testGenerateIgnoresWidthAndHeight(): void
    {
        $url1 = $this->provider->generate(1920, 1080);
        $url2 = $this->provider->generate(640, 480);
        $url3 = $this->provider->generate(3840, 2160);

        // All should return same base URL
        $this->assertStringContainsString('commondatastorage.googleapis.com', $url1);
        $this->assertStringContainsString('commondatastorage.googleapis.com', $url2);
        $this->assertStringContainsString('commondatastorage.googleapis.com', $url3);
    }

    public function testSupportsOnlyVideoOption(): void
    {
        $this->assertTrue($this->provider->supportsOption('video'));
        $this->assertFalse($this->provider->supportsOption('duration'));
        $this->assertFalse($this->provider->supportsOption('fps'));
        $this->assertFalse($this->provider->supportsOption('width'));
        $this->assertFalse($this->provider->supportsOption('height'));
        $this->assertFalse($this->provider->supportsOption(''));
    }

    public function testGetAvailableVideosReturnsCompleteList(): void
    {
        $videos = GoogleCloudStorageVideoProvider::getAvailableVideos();

        $this->assertIsArray($videos);
        $this->assertCount(13, $videos);
        $this->assertContains('big-buck-bunny', $videos);
        $this->assertContains('sintel', $videos);
        $this->assertContains('elephants-dream', $videos);
        $this->assertContains('tears-of-steel', $videos);
        $this->assertContains('for-bigger-blazes', $videos);
        $this->assertContains('for-bigger-escapes', $videos);
        $this->assertContains('for-bigger-fun', $videos);
        $this->assertContains('for-bigger-joyrides', $videos);
        $this->assertContains('for-bigger-meltdowns', $videos);
        $this->assertContains('subaru-outback', $videos);
        $this->assertContains('vw-gti-review', $videos);
        $this->assertContains('we-are-going-on-bullrun', $videos);
        $this->assertContains('what-car-can-you-get', $videos);
    }

    public function testAllAvailableVideosGenerateValidUrls(): void
    {
        foreach (GoogleCloudStorageVideoProvider::getAvailableVideos() as $video) {
            $url = $this->provider->generate(1920, 1080, ['video' => $video]);

            $this->assertStringContainsString('commondatastorage.googleapis.com', $url);
            $this->assertStringContainsString('.mp4', $url);
        }
    }
}
