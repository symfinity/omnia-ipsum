<?php

declare(strict_types=1);

namespace Symfinity\OmniaIpsum\Tests\Twig\Runtime;

use Symfinity\OmniaIpsum\Service\VideoProviderManager;
use Symfinity\OmniaIpsum\Twig\Runtime\VideoRuntime;
use PHPUnit\Framework\TestCase;

final class VideoRuntimeTest extends TestCase
{
    private VideoRuntime $runtime;

    protected function setUp(): void
    {
        $config = [
            'videos' => [
                'default_provider' => 'gcs',
            ],
        ];

        $videoManager = new VideoProviderManager($config);
        $this->runtime = new VideoRuntime($videoManager);
    }

    public function testOmniaVideo(): void
    {
        $url = $this->runtime->omniaVideo(1920, 1080);

        $this->assertIsString($url);
        $this->assertStringContainsString('https://', $url);
    }
}
