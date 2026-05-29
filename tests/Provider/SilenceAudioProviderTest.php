<?php

declare(strict_types=1);

namespace Symfinity\OmniaIpsum\Tests\Provider;

use Symfinity\OmniaIpsum\Provider\SilenceAudioProvider;
use PHPUnit\Framework\TestCase;

final class SilenceAudioProviderTest extends TestCase
{
    private SilenceAudioProvider $provider;

    protected function setUp(): void
    {
        $this->provider = new SilenceAudioProvider();
    }

    public function testGenerate(): void
    {
        $url = $this->provider->generate(10);

        $this->assertStringStartsWith('data:audio/wav;base64,', $url);
    }

    public function testGenerateWithCustomSampleRate(): void
    {
        $url = $this->provider->generate(10, [
            'sample_rate' => 48000,
        ]);

        $this->assertIsString($url);
        $this->assertStringStartsWith('data:audio/wav;base64,', $url);
    }

    public function testGenerateWithCustomChannels(): void
    {
        $url = $this->provider->generate(10, [
            'channels' => 1,
        ]);

        $this->assertIsString($url);
        $this->assertStringStartsWith('data:audio/wav;base64,', $url);
    }

    public function testGenerateWithAllOptions(): void
    {
        $url = $this->provider->generate(5, [
            'sample_rate' => 22050,
            'channels' => 2,
        ]);

        $this->assertIsString($url);
        $this->assertStringStartsWith('data:audio/wav;base64,', $url);
        $this->assertNotEmpty($url);
    }

    public function testGenerateWithDurationLimits(): void
    {
        // Test duration is limited to 60 seconds
        $url1 = $this->provider->generate(1);
        $url60 = $this->provider->generate(60);
        $url100 = $this->provider->generate(100); // Should be clamped to 60

        $this->assertIsString($url1);
        $this->assertIsString($url60);
        $this->assertIsString($url100);

        // Longer duration = longer base64 string
        $this->assertLessThan(\strlen($url60), \strlen($url1));

        // 100s should be clamped to 60s
        $this->assertSame(\strlen($url60), \strlen($url100));
    }

    public function testGenerateCreatesValidWavHeader(): void
    {
        $url = $this->provider->generate(1);

        // Decode base64
        $base64 = str_replace('data:audio/wav;base64,', '', $url);
        $decoded = base64_decode($base64, true);

        $this->assertNotFalse($decoded);
        $this->assertIsString($decoded);

        // Check WAV header
        $this->assertStringStartsWith('RIFF', $decoded);
        $this->assertStringContainsString('WAVE', $decoded);
        $this->assertStringContainsString('fmt ', $decoded);
        $this->assertStringContainsString('data', $decoded);
    }

    public function testGetName(): void
    {
        $this->assertSame('silence', $this->provider->getName());
    }

    public function testSupportsOption(): void
    {
        $this->assertTrue($this->provider->supportsOption('sample_rate'));
        $this->assertTrue($this->provider->supportsOption('channels'));
        $this->assertFalse($this->provider->supportsOption('duration'));
        $this->assertFalse($this->provider->supportsOption('format'));
    }

    public function testGenerateWithDifferentDurations(): void
    {
        $durations = [1, 5, 10, 30, 60];

        foreach ($durations as $duration) {
            $url = $this->provider->generate($duration);

            $this->assertIsString($url);
            $this->assertStringStartsWith('data:audio/wav;base64,', $url);
        }
    }

    public function testGenerateMonoVsStereo(): void
    {
        $mono = $this->provider->generate(10, ['channels' => 1]);
        $stereo = $this->provider->generate(10, ['channels' => 2]);

        // Stereo should be larger (2x channels)
        $this->assertGreaterThan(\strlen($mono), \strlen($stereo));
    }
}
