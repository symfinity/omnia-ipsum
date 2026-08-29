<?php

declare(strict_types=1);

namespace Symfinity\OmniaIpsum\Tests\Provider;

use Symfinity\OmniaIpsum\Provider\PlaceholderProvider;
use PHPUnit\Framework\TestCase;

final class PlaceholderProviderTest extends TestCase
{
    private PlaceholderProvider $provider;

    protected function setUp(): void
    {
        $this->provider = new PlaceholderProvider();
    }

    public function testGenerate(): void
    {
        $url = $this->provider->generate(600, 400);

        $this->assertStringContainsString('https://via.placeholder.com/600x400', $url);
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
            'text' => 'Hello World',
        ]);

        $this->assertStringContainsString('Hello+World', $url);
    }

    public function testGetName(): void
    {
        $this->assertSame('placeholder', $this->provider->getName());
    }

    public function testSupportsOption(): void
    {
        $this->assertTrue($this->provider->supportsOption('background'));
        $this->assertTrue($this->provider->supportsOption('foreground'));
        $this->assertTrue($this->provider->supportsOption('text'));
        $this->assertFalse($this->provider->supportsOption('grayscale'));
    }
}
