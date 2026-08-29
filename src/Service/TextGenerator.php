<?php

declare(strict_types=1);

namespace Symfinity\OmniaIpsum\Service;

/**
 * Lorem Ipsum text generator.
 */
final class TextGenerator
{
    private const LOREM_WORDS = [
        'lorem', 'ipsum', 'dolor', 'sit', 'amet', 'consectetur', 'adipiscing', 'elit',
        'sed', 'do', 'eiusmod', 'tempor', 'incididunt', 'ut', 'labore', 'et', 'dolore',
        'magna', 'aliqua', 'enim', 'ad', 'minim', 'veniam', 'quis', 'nostrud',
        'exercitation', 'ullamco', 'laboris', 'nisi', 'aliquip', 'ex', 'ea', 'commodo',
        'consequat', 'duis', 'aute', 'irure', 'in', 'reprehenderit', 'voluptate',
        'velit', 'esse', 'cillum', 'fugiat', 'nulla', 'pariatur', 'excepteur', 'sint',
        'occaecat', 'cupidatat', 'non', 'proident', 'sunt', 'culpa', 'qui', 'officia',
        'deserunt', 'mollit', 'anim', 'id', 'est', 'laborum',
    ];

    /**
     * @param array<string, mixed> $config
     */
    public function __construct(private readonly array $config) // @phpstan-ignore-line
    {
    }

    /**
     * Generate Lorem Ipsum paragraphs.
     */
    public function paragraphs(int $count): string
    {
        $paragraphs = [];

        for ($i = 0; $i < $count; ++$i) {
            $paragraphs[] = $this->paragraph();
        }

        return implode("\n\n", $paragraphs);
    }

    /**
     * Generate a single Lorem Ipsum paragraph.
     */
    public function paragraph(): string
    {
        $sentenceCount = random_int(3, 7);
        $sentences = [];

        for ($i = 0; $i < $sentenceCount; ++$i) {
            $sentences[] = $this->sentence();
        }

        return implode(' ', $sentences);
    }

    /**
     * Generate Lorem Ipsum sentences.
     */
    public function sentences(int $count): string
    {
        $sentences = [];

        for ($i = 0; $i < $count; ++$i) {
            $sentences[] = $this->sentence();
        }

        return implode(' ', $sentences);
    }

    /**
     * Generate a single Lorem Ipsum sentence.
     */
    public function sentence(): string
    {
        $wordCount = random_int(4, 16);

        return ucfirst($this->words($wordCount)) . '.';
    }

    /**
     * Generate Lorem Ipsum words.
     */
    public function words(int $count): string
    {
        $words = [];
        $availableWords = self::LOREM_WORDS;

        for ($i = 0; $i < $count; ++$i) {
            $words[] = $availableWords[array_rand($availableWords)];
        }

        return implode(' ', $words);
    }

    /**
     * Generate a Lorem Ipsum title (capitalized, 3-6 words).
     */
    public function title(): string
    {
        $wordCount = random_int(3, 6);
        $words = [];
        $availableWords = self::LOREM_WORDS;

        for ($i = 0; $i < $wordCount; ++$i) {
            $word = $availableWords[array_rand($availableWords)];
            $words[] = ucfirst($word);
        }

        return implode(' ', $words);
    }
}
