<?php

declare(strict_types=1);

namespace Symfinity\OmniaIpsum\Tests\Twig\Runtime;

use Symfinity\OmniaIpsum\Service\FakerFactory;
use Symfinity\OmniaIpsum\Twig\Runtime\FakerRuntime;
use PHPUnit\Framework\TestCase;

final class FakerRuntimeTest extends TestCase
{
    private FakerRuntime $runtime;

    protected function setUp(): void
    {
        $config = [
            'faker' => [
                'locale' => 'en_US',
                'seed' => null,
            ],
        ];

        $fakerFactory = new FakerFactory($config);
        $this->runtime = new FakerRuntime($fakerFactory);
    }

    public function testFake(): void
    {
        $name = $this->runtime->fake('name');

        $this->assertIsString($name);
        $this->assertNotEmpty($name);
    }

    public function testFakeText(): void
    {
        $text = $this->runtime->fakeText(200);

        $this->assertIsString($text);
        $this->assertNotEmpty($text);
        $this->assertLessThanOrEqual(220, \strlen($text)); // Approximate
    }
}
