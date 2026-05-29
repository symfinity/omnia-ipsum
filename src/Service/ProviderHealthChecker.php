<?php

declare(strict_types=1);

namespace Symfinity\OmniaIpsum\Service;

/**
 * Service to check the health/availability of providers.
 */
final class ProviderHealthChecker
{
    /**
     * @var array<string, bool> Cache for health check results
     */
    private array $healthCache = [];

    /**
     * @var array<string, int> Timestamps for cache expiration
     */
    private array $cacheTimestamps = [];

    private const CACHE_TTL = 300; // 5 minutes

    public function __construct(
        private readonly ImageProviderManager $imageProviderManager,
        private readonly VideoProviderManager $videoProviderManager,
        private readonly AudioProviderManager $audioProviderManager,
    ) {
    }

    /**
     * Check if an image provider is healthy (URL is accessible).
     */
    public function checkImageProvider(string $providerName, int $timeout = 5): bool
    {
        $cacheKey = "image:{$providerName}";

        if ($this->isCacheValid($cacheKey)) {
            return $this->healthCache[$cacheKey];
        }

        try {
            $provider = $this->imageProviderManager->getProvider($providerName);
            $url = $provider->generate(100, 100);

            $isHealthy = $this->checkUrl($url, $timeout);

            $this->setCache($cacheKey, $isHealthy);

            return $isHealthy;
        } catch (\InvalidArgumentException $e) {
            // Re-throw InvalidArgumentException (provider not found)
            throw $e;
        } catch (\Exception) {
            $this->setCache($cacheKey, false);

            return false;
        }
    }

    /**
     * Check if a video provider is healthy.
     */
    public function checkVideoProvider(string $providerName, int $timeout = 5): bool
    {
        $cacheKey = "video:{$providerName}";

        if ($this->isCacheValid($cacheKey)) {
            return $this->healthCache[$cacheKey];
        }

        try {
            $provider = $this->videoProviderManager->getProvider($providerName);
            $url = $provider->generate(1920, 1080);

            $isHealthy = $this->checkUrl($url, $timeout);

            $this->setCache($cacheKey, $isHealthy);

            return $isHealthy;
        } catch (\InvalidArgumentException $e) {
            // Re-throw InvalidArgumentException (provider not found)
            throw $e;
        } catch (\Exception) {
            $this->setCache($cacheKey, false);

            return false;
        }
    }

    /**
     * Check if an audio provider is healthy.
     */
    public function checkAudioProvider(string $providerName, int $timeout = 5): bool
    {
        $cacheKey = "audio:{$providerName}";

        if ($this->isCacheValid($cacheKey)) {
            return $this->healthCache[$cacheKey];
        }

        try {
            $provider = $this->audioProviderManager->getProvider($providerName);
            $url = $provider->generate(10);

            // For data URLs (like Silence), they're always healthy
            if (str_starts_with($url, 'data:')) {
                $this->setCache($cacheKey, true);

                return true;
            }

            $isHealthy = $this->checkUrl($url, $timeout);

            $this->setCache($cacheKey, $isHealthy);

            return $isHealthy;
        } catch (\InvalidArgumentException $e) {
            // Re-throw InvalidArgumentException (provider not found)
            throw $e;
        } catch (\Exception) {
            $this->setCache($cacheKey, false);

            return false;
        }
    }

    /**
     * Check all image providers.
     *
     * @return array<string, bool>
     */
    public function checkAllImageProviders(int $timeout = 5): array
    {
        $results = [];

        foreach ($this->imageProviderManager->getProviders() as $provider) {
            $results[$provider->getName()] = $this->checkImageProvider($provider->getName(), $timeout);
        }

        return $results;
    }

    /**
     * Check all video providers.
     *
     * @return array<string, bool>
     */
    public function checkAllVideoProviders(int $timeout = 5): array
    {
        $results = [];

        foreach ($this->videoProviderManager->getProviders() as $provider) {
            $results[$provider->getName()] = $this->checkVideoProvider($provider->getName(), $timeout);
        }

        return $results;
    }

    /**
     * Check all audio providers.
     *
     * @return array<string, bool>
     */
    public function checkAllAudioProviders(int $timeout = 5): array
    {
        $results = [];

        foreach ($this->audioProviderManager->getProviders() as $provider) {
            $results[$provider->getName()] = $this->checkAudioProvider($provider->getName(), $timeout);
        }

        return $results;
    }

    /**
     * Check all providers.
     *
     * @return array{images: array<string, bool>, videos: array<string, bool>, audios: array<string, bool>}
     */
    public function checkAllProviders(int $timeout = 5): array
    {
        return [
            'images' => $this->checkAllImageProviders($timeout),
            'videos' => $this->checkAllVideoProviders($timeout),
            'audios' => $this->checkAllAudioProviders($timeout),
        ];
    }

    /**
     * Clear the health check cache.
     */
    public function clearCache(): void
    {
        $this->healthCache = [];
        $this->cacheTimestamps = [];
    }

    /**
     * Check if a URL is accessible.
     */
    private function checkUrl(string $url, int $timeout): bool
    {
        $context = stream_context_create([
            'http' => [
                'method' => 'HEAD',
                'timeout' => $timeout,
                'follow_location' => true,
                'max_redirects' => 3,
                'ignore_errors' => true,
            ],
        ]);

        $headers = @get_headers($url, false, $context);

        if (false === $headers) {
            return false;
        }

        $statusCode = $this->extractStatusCode($headers);

        return $statusCode >= 200 && $statusCode < 400;
    }

    /**
     * Extract HTTP status code from headers.
     *
     * @param array<int|string, string|array<int, string>> $headers
     */
    private function extractStatusCode(array $headers): int
    {
        if (isset($headers[0]) && is_string($headers[0])) {
            if (preg_match('/HTTP\/\d\.\d\s+(\d+)/', $headers[0], $matches)) {
                return (int) $matches[1];
            }
        }

        return 0;
    }

    /**
     * Check if cache entry is valid.
     */
    private function isCacheValid(string $cacheKey): bool
    {
        if (!isset($this->healthCache[$cacheKey]) || !isset($this->cacheTimestamps[$cacheKey])) {
            return false;
        }

        return (time() - $this->cacheTimestamps[$cacheKey]) < self::CACHE_TTL;
    }

    /**
     * Set cache entry.
     */
    private function setCache(string $cacheKey, bool $value): void
    {
        $this->healthCache[$cacheKey] = $value;
        $this->cacheTimestamps[$cacheKey] = time();
    }
}
