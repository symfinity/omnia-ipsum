<?php

declare(strict_types=1);

namespace Symfinity\OmniaIpsum\Command;

use Symfinity\OmniaIpsum\Service\ProviderHealthChecker;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'omnia:test-providers',
    description: 'Test all providers for availability'
)]
final class TestProvidersCommand extends Command
{
    public function __construct(
        private readonly ProviderHealthChecker $healthChecker,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addOption('timeout', 't', InputOption::VALUE_REQUIRED, 'Timeout in seconds', '5')
            ->addOption('type', null, InputOption::VALUE_REQUIRED, 'Provider type (images, videos, audios, all)', 'all')
            ->addOption('clear-cache', null, InputOption::VALUE_NONE, 'Clear health check cache before testing')
            ->setHelp(
                'The <info>%command.name%</info> command tests all providers for availability.' . "\n\n" .
                'Example: <info>php %command.full_name%</info>' . "\n" .
                'Example: <info>php %command.full_name% --type=images</info>' . "\n" .
                'Example: <info>php %command.full_name% --timeout=10</info>'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $timeoutOption = $input->getOption('timeout');
        $timeout = is_string($timeoutOption) ? (int) $timeoutOption : 5;
        $type = $input->getOption('type');
        $type = is_string($type) ? $type : 'all';
        $clearCache = $input->getOption('clear-cache');

        if ($clearCache) {
            $this->healthChecker->clearCache();
            $io->info('Health check cache cleared.');
        }

        $io->title('Omnia Ipsum - Provider Health Check');

        if ('all' === $type || 'images' === $type) {
            $io->section('Image Providers');
            $results = $this->healthChecker->checkAllImageProviders($timeout);
            $this->displayResults($io, $results);
        }

        if ('all' === $type || 'videos' === $type) {
            $io->section('Video Providers');
            $results = $this->healthChecker->checkAllVideoProviders($timeout);
            $this->displayResults($io, $results);
        }

        if ('all' === $type || 'audios' === $type) {
            $io->section('Audio Providers');
            $results = $this->healthChecker->checkAllAudioProviders($timeout);
            $this->displayResults($io, $results);
        }

        return Command::SUCCESS;
    }

    /**
     * Display health check results.
     *
     * @param array<string, bool> $results
     */
    private function displayResults(SymfonyStyle $io, array $results): void
    {
        if (empty($results)) {
            $io->warning('No providers to test.');

            return;
        }

        $rows = [];
        $healthyCount = 0;

        foreach ($results as $providerName => $isHealthy) {
            $status = $isHealthy ? '<fg=green>✓ Healthy</>' : '<fg=red>✗ Unavailable</>';
            $rows[] = [$providerName, $status];

            if ($isHealthy) {
                ++$healthyCount;
            }
        }

        $io->table(['Provider', 'Status'], $rows);

        $total = count($results);
        if ($healthyCount === $total) {
            $io->success(sprintf('All %d provider(s) are healthy.', $total));
        } else {
            $io->warning(sprintf('%d of %d provider(s) are healthy.', $healthyCount, $total));
        }
    }
}
