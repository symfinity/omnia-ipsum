<?php

declare(strict_types=1);

namespace Symfinity\OmniaIpsum\Tests\Provider;

use Symfinity\OmniaIpsum\Provider\PicsumProvider;
use PHPUnit\Framework\TestCase;

final class PicsumProviderEdgeCasesTest extends TestCase
{
    private PicsumProvider $provider;

    protected function setUp(): void
    {
        $this->provider = new PicsumProvider();
    }

    public function testGenerateWithAllOptionsTrue(): void
    {
        $url = $this->provider->generate(800, 600, [
            'grayscale' => true,
            'blur' => 5,
            'seed' => 42,
        ]);

        $this->assertStringContainsString('picsum.photos/800/600', $url);
        $this->assertStringContainsString('grayscale', $url);
        $this->assertStringContainsString('blur=5', $url);
        $this->assertStringContainsString('random=42', $url);
    }

    public function testGenerateWithGrayscaleFalse(): void
    {
        $url = $this->provider->generate(800, 600, ['grayscale' => false]);

        $this->assertStringNotContainsString('grayscale', $url);
    }

    public function testGenerateWithBlurZero(): void
    {
        $url = $this->provider->generate(800, 600, ['blur' => 0]);

        $this->assertStringContainsString('blur=0', $url);
    }

    public function testGenerateWithSeedZero(): void
    {
        $url = $this->provider->generate(800, 600, ['seed' => 0]);

        $this->assertStringContainsString('random=0', $url);
    }

    public function testGenerateWithBlurMaxValue(): void
    {
        $url = $this->provider->generate(800, 600, ['blur' => 10]);

        $this->assertStringContainsString('blur=10', $url);
    }

    public function testGenerateWithNegativeBlur(): void
    {
        $url = $this->provider->generate(800, 600, ['blur' => -5]);

        $this->assertStringContainsString('blur=-5', $url);
    }

    public function testGenerateWithLargeSeed(): void
    {
        $url = $this->provider->generate(800, 600, ['seed' => 999999]);

        $this->assertStringContainsString('random=999999', $url);
    }

    public function testSupportsOptionReturnsFalseForInvalid(): void
    {
        $this->assertFalse($this->provider->supportsOption('invalid'));
        $this->assertFalse($this->provider->supportsOption('width'));
        $this->assertFalse($this->provider->supportsOption('height'));
        $this->assertFalse($this->provider->supportsOption(''));
    }
}
