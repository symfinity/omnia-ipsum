<?php

declare(strict_types=1);

namespace Symfinity\OmniaIpsum\Provider;

/**
 * Google Cloud Storage video provider.
 *
 * Uses public videos from Google's gtv-videos-bucket.
 * These are reliable, fast, and free to use.
 *
 * Available videos: BigBuckBunny, ElephantsDream, ForBiggerBlazes,
 * ForBiggerEscapes, ForBiggerFun, ForBiggerJoyrides, ForBiggerMeltdowns,
 * Sintel, SubaruOutbackOnStreetAndDirt, TearsOfSteel, VolkswagenGTIReview,
 * WeAreGoingOnBullrun, WhatCarCanYouGetForAGrand
 */
final class GoogleCloudStorageVideoProvider implements VideoProviderInterface
{
    private const BASE_URL = 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample';

    private const VIDEOS = [
        'big-buck-bunny' => 'BigBuckBunny.mp4',
        'elephants-dream' => 'ElephantsDream.mp4',
        'for-bigger-blazes' => 'ForBiggerBlazes.mp4',
        'for-bigger-escapes' => 'ForBiggerEscapes.mp4',
        'for-bigger-fun' => 'ForBiggerFun.mp4',
        'for-bigger-joyrides' => 'ForBiggerJoyrides.mp4',
        'for-bigger-meltdowns' => 'ForBiggerMeltdowns.mp4',
        'sintel' => 'Sintel.mp4',
        'subaru-outback' => 'SubaruOutbackOnStreetAndDirt.mp4',
        'tears-of-steel' => 'TearsOfSteel.mp4',
        'vw-gti-review' => 'VolkswagenGTIReview.mp4',
        'we-are-going-on-bullrun' => 'WeAreGoingOnBullrun.mp4',
        'what-car-can-you-get' => 'WhatCarCanYouGetForAGrand.mp4',
    ];

    public function generate(int $width, int $height, array $options = []): string
    {
        $video = $options['video'] ?? 'big-buck-bunny';

        $filename = self::VIDEOS[$video] ?? self::VIDEOS['big-buck-bunny'];

        return sprintf('%s/%s', self::BASE_URL, $filename);
    }

    public function getName(): string
    {
        return 'gcs';
    }

    public function supportsOption(string $option): bool
    {
        return 'video' === $option;
    }

    /**
     * Get available videos.
     *
     * @return array<string>
     */
    public static function getAvailableVideos(): array
    {
        return array_keys(self::VIDEOS);
    }
}
