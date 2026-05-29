<?php

declare(strict_types=1);

namespace Symfinity\OmniaIpsum\Provider;

/**
 * Generates data URLs for silent audio (WAV format).
 *
 * This provider generates base64-encoded silent WAV files
 * that can be used as data URLs in audio tags.
 */
final class SilenceAudioProvider implements AudioProviderInterface
{
    public function generate(int $duration, array $options = []): string
    {
        $sampleRate = $options['sample_rate'] ?? 44100;
        $channels = $options['channels'] ?? 2;

        // Limit duration to prevent memory issues
        $duration = min(60, max(1, $duration));

        // Generate silent WAV file
        $samples = $sampleRate * $duration;
        $dataSize = $samples * $channels * 2; // 16-bit = 2 bytes per sample
        $fileSize = $dataSize + 36; // Header is 44 bytes, minus 8 for RIFF chunk size

        // WAV header
        $header = pack(
            'A4VA4A4VvvVVvvA4V',
            'RIFF',
            $fileSize,
            'WAVE',
            'fmt ',
            16,                      // Subchunk1Size (PCM)
            1,                       // AudioFormat (PCM)
            $channels,               // NumChannels
            $sampleRate,             // SampleRate
            $sampleRate * $channels * 2, // ByteRate
            $channels * 2,           // BlockAlign
            16,                      // BitsPerSample
            'data',
            $dataSize
        );

        // Silent data (all zeros)
        $data = str_repeat("\x00", $dataSize);

        $wavContent = $header . $data;

        // Return as data URL
        return 'data:audio/wav;base64,' . base64_encode($wavContent);
    }

    public function getName(): string
    {
        return 'silence';
    }

    public function supportsOption(string $option): bool
    {
        return \in_array($option, ['sample_rate', 'channels'], true);
    }
}
