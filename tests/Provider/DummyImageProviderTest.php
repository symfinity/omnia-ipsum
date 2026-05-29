<?php

declare(strict_types=1);

namespace Symfinity\OmniaIpsum\Tests\Provider;

use Symfinity\OmniaIpsum\Provider\DummyImageProvider;
use PHPUnit\Framework\TestCase;

final class DummyImageProviderTest extends TestCase
{
    private DummyImageProvider $provider;

    protected function setUp(): void
    {
        $this->provider = new DummyImageProvider();
    }

    public function testGenerate(): void
    {
        $url = $this->provider->generate(600, 400);

        $this->assertStringContainsString('https://dummyimage.com/600x400', $url);
        $this->assertStringContainsString('.png', $url);
    }

    public function testGenerateWithCustomColors(): void
    {
        $url = $this->provider->generate(600, 400, [
            'background' => 'ff0000',
            'foreground' => '000000',
        ]);

        $this->assertStringContainsString('ff0000', $url);
        $this->assertStringContainsString('000000', $url);
    }

    public function testGenerateWithText(): void
    {
        $url = $this->provider->generate(600, 400, [
            'text' => 'Test Image',
        ]);

        $this->assertStringContainsString('Test+Image', $url);
    }

    public function testGenerateWithCustomFormat(): void
    {
        $url = $this->provider->generate(600, 400, [
            'format' => 'jpg',
        ]);

        $this->assertStringContainsString('.jpg', $url);
    }

    public function testGenerateWithAllOptions(): void
    {
        $url = $this->provider->generate(800, 600, [
            'background' => '007bff',
            'foreground' => 'ffffff',
            'text' => 'Hello World',
            'format' => 'gif',
        ]);

        $this->assertStringContainsString('007bff', $url);
        $this->assertStringContainsString('ffffff', $url);
        $this->assertStringContainsString('Hello+World', $url);
        $this->assertStringContainsString('.gif', $url);
    }

    public function testGetName(): void
    {
        $this->assertSame('dummyimage', $this->provider->getName());
    }

    public function testSupportsOption(): void
    {
        $this->assertTrue($this->provider->supportsOption('background'));
        $this->assertTrue($this->provider->supportsOption('foreground'));
        $this->assertTrue($this->provider->supportsOption('text'));
        $this->assertTrue($this->provider->supportsOption('format'));
        $this->assertFalse($this->provider->supportsOption('grayscale'));
        $this->assertFalse($this->provider->supportsOption('blur'));
    }
}
