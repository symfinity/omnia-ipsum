<?php

declare(strict_types=1);

namespace Symfinity\OmniaIpsum\Tests\DependencyInjection;

use Symfinity\OmniaIpsum\DependencyInjection\Configuration;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Definition\Processor;

final class ConfigurationTest extends TestCase
{
    private Configuration $configuration;
    private Processor $processor;

    protected function setUp(): void
    {
        $this->configuration = new Configuration();
        $this->processor = new Processor();
    }

    public function testDefaultConfiguration(): void
    {
        $config = $this->processor->processConfiguration($this->configuration, []);

        $this->assertArrayHasKey('images', $config);
        $this->assertArrayHasKey('text', $config);
        $this->assertArrayHasKey('faker', $config);

        $this->assertSame('picsum', $config['images']['default_provider']);
        $this->assertSame(600, $config['images']['default_width']);
        $this->assertSame(400, $config['images']['default_height']);
        $this->assertSame('cccccc', $config['images']['default_background']);
        $this->assertSame('333333', $config['images']['default_foreground']);
        $this->assertNull($config['images']['default_text']);

        $this->assertSame(3, $config['text']['default_paragraphs']);
        $this->assertSame(5, $config['text']['default_sentences']);
        $this->assertSame(50, $config['text']['default_words']);

        $this->assertSame('en_US', $config['faker']['locale']);
        $this->assertNull($config['faker']['seed']);

        $this->assertSame('gcs', $config['videos']['default_provider']);
        $this->assertSame(1920, $config['videos']['default_width']);
        $this->assertSame(1080, $config['videos']['default_height']);
        $this->assertSame(30, $config['videos']['default_duration']);
    }

    public function testCustomImageConfiguration(): void
    {
        $config = $this->processor->processConfiguration($this->configuration, [
            'omnia_ipsum' => [
                'images' => [
                    'default_provider' => 'picsum',
                    'default_width' => 1200,
                    'default_height' => 800,
                    'default_background' => 'ff0000',
                    'default_foreground' => '000000',
                    'default_text' => 'Test',
                ],
            ],
        ]);

        $this->assertSame('picsum', $config['images']['default_provider']);
        $this->assertSame(1200, $config['images']['default_width']);
        $this->assertSame(800, $config['images']['default_height']);
        $this->assertSame('ff0000', $config['images']['default_background']);
        $this->assertSame('000000', $config['images']['default_foreground']);
        $this->assertSame('Test', $config['images']['default_text']);
    }

    public function testCustomTextConfiguration(): void
    {
        $config = $this->processor->processConfiguration($this->configuration, [
            'omnia_ipsum' => [
                'text' => [
                    'default_paragraphs' => 10,
                    'default_sentences' => 20,
                    'default_words' => 100,
                ],
            ],
        ]);

        $this->assertSame(10, $config['text']['default_paragraphs']);
        $this->assertSame(20, $config['text']['default_sentences']);
        $this->assertSame(100, $config['text']['default_words']);
    }

    public function testCustomFakerConfiguration(): void
    {
        $config = $this->processor->processConfiguration($this->configuration, [
            'omnia_ipsum' => [
                'faker' => [
                    'locale' => 'de_DE',
                    'seed' => 42,
                ],
            ],
        ]);

        $this->assertSame('de_DE', $config['faker']['locale']);
        $this->assertSame(42, $config['faker']['seed']);
    }
}
