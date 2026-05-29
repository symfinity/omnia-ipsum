<?php

declare(strict_types=1);

namespace Symfinity\OmniaIpsum\Command;

use Symfinity\OmniaIpsum\Service\AudioProviderManager;
use Symfinity\OmniaIpsum\Service\ImageProviderManager;
use Symfinity\OmniaIpsum\Service\VideoProviderManager;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'omnia:validate',
    description: 'Validate Omnia Ipsum configuration'
)]
final class ValidateCommand extends Command
{
    public function __construct(
        private readonly ImageProviderManager $imageProviderManager,
        private readonly VideoProviderManager $videoProviderManager,
        private readonly AudioProviderManager $audioProviderManager,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $io->title('Omnia Ipsum - Configuration Validation');

        $errors = [];
        $warnings = [];

        // Validate Image Providers
        $imageProviders = $this->imageProviderManager->getProviders();
        if (empty($imageProviders)) {
            $errors[] = 'No image providers registered.';
        } else {
            $io->section('Image Providers');
            $io->success(sprintf('%d image provider(s) registered.', count($imageProviders)));

            foreach ($imageProviders as $provider) {
                try {
                    $url = $provider->generate(100, 100);
                    if (empty($url)) {
                        $warnings[] = sprintf('Image provider "%s" generated empty URL.', $provider->getName());
                    }
                } catch (\Exception $e) {
                    $errors[] = sprintf('Image provider "%s" failed: %s', $provider->getName(), $e->getMessage());
                }
            }
        }

        // Validate Video Providers
        $videoProviders = $this->videoProviderManager->getProviders();
        if (empty($videoProviders)) {
            $warnings[] = 'No video providers registered.';
        } else {
            $io->section('Video Providers');
            $io->success(sprintf('%d video provider(s) registered.', count($videoProviders)));

            foreach ($videoProviders as $provider) {
                try {
                    $url = $provider->generate(1920, 1080);
                    if (empty($url)) {
                        $warnings[] = sprintf('Video provider "%s" generated empty URL.', $provider->getName());
                    }
                } catch (\Exception $e) {
                    $errors[] = sprintf('Video provider "%s" failed: %s', $provider->getName(), $e->getMessage());
                }
            }
        }

        // Validate Audio Providers
        $audioProviders = $this->audioProviderManager->getProviders();
        if (empty($audioProviders)) {
            $warnings[] = 'No audio providers registered.';
        } else {
            $io->section('Audio Providers');
            $io->success(sprintf('%d audio provider(s) registered.', count($audioProviders)));

            foreach ($audioProviders as $provider) {
                try {
                    $url = $provider->generate(10);
                    if (empty($url)) {
                        $warnings[] = sprintf('Audio provider "%s" generated empty URL.', $provider->getName());
                    }
                } catch (\Exception $e) {
                    $errors[] = sprintf('Audio provider "%s" failed: %s', $provider->getName(), $e->getMessage());
                }
            }
        }

        // Display results
        if (!empty($warnings)) {
            $io->section('Warnings');
            foreach ($warnings as $warning) {
                $io->warning($warning);
            }
        }

        if (!empty($errors)) {
            $io->section('Errors');
            foreach ($errors as $error) {
                $io->error($error);
            }

            return Command::FAILURE;
        }

        $io->success('Configuration is valid!');

        return Command::SUCCESS;
    }
}
