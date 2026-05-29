<?php

declare(strict_types=1);

namespace Symfinity\OmniaIpsum\Tests\Provider;

use Symfinity\OmniaIpsum\Provider\UiAvatarsProvider;
use PHPUnit\Framework\TestCase;

final class UiAvatarsProviderTest extends TestCase
{
    private UiAvatarsProvider $provider;

    protected function setUp(): void
    {
        $this->provider = new UiAvatarsProvider();
    }

    public function testGenerate(): void
    {
        $url = $this->provider->generate(100, 100, ['name' => 'John Doe']);

        $this->assertStringContainsString('https://ui-avatars.com/api/', $url);
        $this->assertStringContainsString('name=John+Doe', $url);
        $this->assertStringContainsString('size=100', $url);
    }

    public function testGenerateWithCustomColors(): void
    {
        $url = $this->provider->generate(100, 100, [
            'name' => 'Test',
            'background' => 'ff0000',
            'foreground' => '000000',
        ]);

        $this->assertStringContainsString('background=ff0000', $url);
        $this->assertStringContainsString('color=000000', $url);
    }

    public function testGenerateWithBold(): void
    {
        $url = $this->provider->generate(100, 100, [
            'name' => 'Test',
            'bold' => true,
        ]);

        $this->assertStringContainsString('bold=true', $url);
    }

    public function testGenerateWithRounded(): void
    {
        $url = $this->provider->generate(100, 100, [
            'name' => 'Test',
            'rounded' => true,
        ]);

        $this->assertStringContainsString('rounded=true', $url);
    }

    public function testGenerateWithAllOptions(): void
    {
        $url = $this->provider->generate(120, 120, [
            'name' => 'Jane Smith',
            'background' => '007bff',
            'foreground' => 'ffffff',
            'bold' => true,
            'rounded' => true,
        ]);

        $this->assertStringContainsString('name=Jane+Smith', $url);
        $this->assertStringContainsString('background=007bff', $url);
        $this->assertStringContainsString('color=ffffff', $url);
        $this->assertStringContainsString('bold=true', $url);
        $this->assertStringContainsString('rounded=true', $url);
        $this->assertStringContainsString('size=120', $url);
    }

    public function testGenerateWithNonSquareSize(): void
    {
        // UI Avatars only supports square images, should use smaller dimension
        $url = $this->provider->generate(200, 100, ['name' => 'Test']);

        $this->assertStringContainsString('size=100', $url);
    }

    public function testGetName(): void
    {
        $this->assertSame('ui-avatars', $this->provider->getName());
    }

    public function testSupportsOption(): void
    {
        $this->assertTrue($this->provider->supportsOption('name'));
        $this->assertTrue($this->provider->supportsOption('background'));
        $this->assertTrue($this->provider->supportsOption('foreground'));
        $this->assertTrue($this->provider->supportsOption('bold'));
        $this->assertTrue($this->provider->supportsOption('rounded'));
        $this->assertFalse($this->provider->supportsOption('text'));
        $this->assertFalse($this->provider->supportsOption('grayscale'));
    }
}
