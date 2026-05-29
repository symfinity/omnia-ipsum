<?php

declare(strict_types=1);

namespace Symfinity\OmniaIpsum\Tests\DependencyInjection;

use Symfinity\OmniaIpsum\DependencyInjection\OmniaIpsumExtension;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class OmniaIpsumExtensionTest extends TestCase
{
    private OmniaIpsumExtension $extension;
    private ContainerBuilder $container;

    protected function setUp(): void
    {
        $this->extension = new OmniaIpsumExtension();
        $this->container = new ContainerBuilder();
    }

    public function testLoad(): void
    {
        $this->extension->load([], $this->container);

        $this->assertTrue($this->container->hasParameter('omnia_ipsum.config'));
    }

    public function testLoadWithConfiguration(): void
    {
        $config = [
            'omnia_ipsum' => [
                'images' => [
                    'default_provider' => 'picsum',
                ],
                'faker' => [
                    'locale' => 'de_DE',
                ],
            ],
        ];

        $this->extension->load($config, $this->container);

        $this->assertTrue($this->container->hasParameter('omnia_ipsum.config'));

        $configParam = $this->container->getParameter('omnia_ipsum.config');
        $this->assertIsArray($configParam);
        $this->assertArrayHasKey('images', $configParam);
        $this->assertArrayHasKey('faker', $configParam);
    }
}
