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
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

final class CommandTest extends TestCase
{
    private Application $application;

    protected function setUp(): void
    {
        $config = [
            'images' => ['default_provider' => 'picsum'],
            'videos' => ['default_provider' => 'gcs'],
            'audios' => ['default_provider' => 'silence'],
        ];

        $imageManager = new ImageProviderManager($config);
        $videoManager = new VideoProviderManager($config);
        $audioManager = new AudioProviderManager($config);
        $healthChecker = new ProviderHealthChecker($imageManager, $videoManager, $audioManager);

        $this->application = new Application();
        $this->application->add(new ListProvidersCommand($imageManager, $videoManager, $audioManager));
        $this->application->add(new TestProvidersCommand($healthChecker));
        $this->application->add(new ValidateCommand($imageManager, $videoManager, $audioManager));
    }

    public function testListProvidersCommand(): void
    {
        $command = $this->application->find('omnia:list-providers');
        $commandTester = new CommandTester($command);

        $exitCode = $commandTester->execute([]);

        $this->assertSame(0, $exitCode);
        $output = $commandTester->getDisplay();
        $this->assertStringContainsString('Image Providers', $output);
        $this->assertStringContainsString('Video Providers', $output);
        $this->assertStringContainsString('Audio Providers', $output);
    }

    public function testTestProvidersCommand(): void
    {
        $command = $this->application->find('omnia:test-providers');
        $commandTester = new CommandTester($command);

        $exitCode = $commandTester->execute([
            '--timeout' => '2',
        ]);

        $this->assertSame(0, $exitCode);
        $output = $commandTester->getDisplay();
        $this->assertStringContainsString('Provider Health Check', $output);
    }

    public function testTestProvidersCommandWithType(): void
    {
        $command = $this->application->find('omnia:test-providers');
        $commandTester = new CommandTester($command);

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
        $command = $this->application->find('omnia:validate');
        $commandTester = new CommandTester($command);

        $exitCode = $commandTester->execute([]);

        $this->assertSame(0, $exitCode);
        $output = $commandTester->getDisplay();
        $this->assertStringContainsString('Configuration Validation', $output);
        $this->assertStringContainsString('Configuration is valid', $output);
    }
}
