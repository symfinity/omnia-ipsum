<?php

declare(strict_types=1);

namespace Symfinity\OmniaIpsum\Tests\Integration;

use Symfinity\OmniaIpsum\Command\ListProvidersCommand;
use Symfinity\OmniaIpsum\Command\TestProvidersCommand;
use Symfinity\OmniaIpsum\Command\ValidateCommand;
use Symfinity\OmniaIpsum\Service\AudioProviderManager;
use Symfinity\OmniaIpsum\Service\ImageProviderManager;
use Symfinity\OmniaIpsum\Service\ProviderHealthChecker;
use Symfinity\OmniaIpsum\Service\VideoProviderManager;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Tester\CommandTester;

final class CommandTest extends TestCase
{
    private ImageProviderManager $imageManager;

    private VideoProviderManager $videoManager;

    private AudioProviderManager $audioManager;

    private ProviderHealthChecker $healthChecker;

    protected function setUp(): void
    {
        $config = [
            'images' => ['default_provider' => 'picsum'],
            'videos' => ['default_provider' => 'gcs'],
            'audios' => ['default_provider' => 'silence'],
        ];

        $this->imageManager = new ImageProviderManager($config);
        $this->videoManager = new VideoProviderManager($config);
        $this->audioManager = new AudioProviderManager($config);
        $this->healthChecker = new ProviderHealthChecker($this->imageManager, $this->videoManager, $this->audioManager);
    }

    public function testListProvidersCommand(): void
    {
        $commandTester = new CommandTester(new ListProvidersCommand($this->imageManager, $this->videoManager, $this->audioManager));

        $exitCode = $commandTester->execute([]);

        $this->assertSame(0, $exitCode);
        $output = $commandTester->getDisplay();
        $this->assertStringContainsString('Image Providers', $output);
        $this->assertStringContainsString('Video Providers', $output);
        $this->assertStringContainsString('Audio Providers', $output);
    }

    public function testTestProvidersCommand(): void
    {
        $commandTester = new CommandTester(new TestProvidersCommand($this->healthChecker));

        $exitCode = $commandTester->execute([
            '--timeout' => '2',
        ]);

        $this->assertSame(0, $exitCode);
        $output = $commandTester->getDisplay();
        $this->assertStringContainsString('Provider Health Check', $output);
    }

    public function testTestProvidersCommandWithType(): void
    {
        $commandTester = new CommandTester(new TestProvidersCommand($this->healthChecker));

        $exitCode = $commandTester->execute([
            '--type' => 'images',
            '--timeout' => '2',
        ]);

        $this->assertSame(0, $exitCode);
        $output = $commandTester->getDisplay();
        $this->assertStringContainsString('Image Providers', $output);
    }

    public function testValidateCommand(): void
    {
        $commandTester = new CommandTester(new ValidateCommand($this->imageManager, $this->videoManager, $this->audioManager));

        $exitCode = $commandTester->execute([]);

        $this->assertSame(0, $exitCode);
        $output = $commandTester->getDisplay();
        $this->assertStringContainsString('Configuration Validation', $output);
        $this->assertStringContainsString('Configuration is valid', $output);
    }
}
