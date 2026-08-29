<?php

declare(strict_types=1);

namespace Symfinity\OmniaIpsum\Tests\Provider;

use Symfinity\OmniaIpsum\Provider\PicsumProvider;
use PHPUnit\Framework\TestCase;

final class PicsumProviderTest extends TestCase
{
    private PicsumProvider $provider;

    protected function setUp(): void
    {
        $this->provider = new PicsumProvider();
    }

    public function testGenerate(): void
    {
        $url = $this->provider->generate(600, 400);

        $this->assertStringContainsString('https://picsum.photos/600/400', $url);
    }

    public function testGenerateWithGrayscale(): void
    {
        $url = $this->provider->generate(600, 400, [
            'grayscale' => true,
        ]);

        $this->assertStringContainsString('grayscale', $url);
    }

    public function testGenerateWithBlur(): void
    {
        $url = $this->provider->generate(600, 400, [
            'blur' => 5,
        ]);

        $this->assertStringContainsString('blur=5', $url);
    }

    public function testGetName(): void
    {
        $this->assertSame('picsum', $this->provider->getName());
    }

    public function testSupportsOption(): void
    {
        $this->assertTrue($this->provider->supportsOption('grayscale'));
        $this->assertTrue($this->provider->supportsOption('blur'));
        $this->assertTrue($this->provider->supportsOption('seed'));
        $this->assertFalse($this->provider->supportsOption('text'));
    }
}
