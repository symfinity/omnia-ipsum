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
    name: 'omnia:list-providers',
    description: 'List all available providers'
)]
final class ListProvidersCommand extends Command
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

        $io->title('Omnia Ipsum - Available Providers');

        // Image Providers
        $io->section('Image Providers');
        $imageProviders = $this->imageProviderManager->getProviders();
        if (empty($imageProviders)) {
            $io->warning('No image providers registered.');
        } else {
            $rows = [];
            foreach ($imageProviders as $provider) {
                $rows[] = [
                    $provider->getName(),
                    $this->getProviderOptions($provider),
                ];
            }
            $io->table(['Name', 'Supported Options'], $rows);
        }

        // Video Providers
        $io->section('Video Providers');
        $videoProviders = $this->videoProviderManager->getProviders();
        if (empty($videoProviders)) {
            $io->warning('No video providers registered.');
        } else {
            $rows = [];
            foreach ($videoProviders as $provider) {
                $rows[] = [
                    $provider->getName(),
                    $this->getProviderOptions($provider),
                ];
            }
            $io->table(['Name', 'Supported Options'], $rows);
        }

        // Audio Providers
        $io->section('Audio Providers');
        $audioProviders = $this->audioProviderManager->getProviders();
        if (empty($audioProviders)) {
            $io->warning('No audio providers registered.');
        } else {
            $rows = [];
            foreach ($audioProviders as $provider) {
                $rows[] = [
                    $provider->getName(),
                    $this->getProviderOptions($provider),
                ];
            }
            $io->table(['Name', 'Supported Options'], $rows);
        }

        return Command::SUCCESS;
    }

    /**
     * Get supported options for a provider.
     *
     * @param \Symfinity\OmniaIpsum\Provider\ImageProviderInterface|\Symfinity\OmniaIpsum\Provider\VideoProviderInterface|\Symfinity\OmniaIpsum\Provider\AudioProviderInterface $provider
     */
    private function getProviderOptions($provider): string
    {
        $commonOptions = ['provider'];
        $options = [];

        // Check common options
        foreach (['seed', 'text', 'background', 'foreground', 'bold', 'rounded', 'video', 'song', 'format'] as $option) {
            if ($provider->supportsOption($option)) {
                $options[] = $option;
            }
        }

        if (empty($options)) {
            return '<comment>none</comment>';
        }

        return implode(', ', $options);
    }
}
