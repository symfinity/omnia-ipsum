<?php

declare(strict_types=1);

namespace Symfinity\OmniaIpsum\Tests\Provider;

use Symfinity\OmniaIpsum\Provider\PlaceholdProvider;
use PHPUnit\Framework\TestCase;

final class PlaceholdProviderTest extends TestCase
{
    private PlaceholdProvider $provider;

    protected function setUp(): void
    {
        $this->provider = new PlaceholdProvider();
    }

    public function testGenerate(): void
    {
        $url = $this->provider->generate(600, 400);

        $this->assertStringContainsString('https://placehold.co/600x400', $url);
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
            'text' => 'Custom Text',
        ]);

        $this->assertStringContainsString('Custom+Text', $url);
    }

    public function testGenerateWithFormat(): void
    {
        $url = $this->provider->generate(600, 400, [
            'format' => 'webp',
        ]);

        $this->assertStringContainsString('.webp', $url);
    }

    public function testGetName(): void
    {
        $this->assertSame('placehold', $this->provider->getName());
    }

    public function testSupportsOption(): void
    {
        $this->assertTrue($this->provider->supportsOption('background'));
        $this->assertTrue($this->provider->supportsOption('foreground'));
        $this->assertTrue($this->provider->supportsOption('text'));
        $this->assertTrue($this->provider->supportsOption('format'));
        $this->assertFalse($this->provider->supportsOption('grayscale'));
    }
}
