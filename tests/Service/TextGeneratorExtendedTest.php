<?php

declare(strict_types=1);

namespace Symfinity\OmniaIpsum\Tests\Service;

use Symfinity\OmniaIpsum\Service\TextGenerator;
use PHPUnit\Framework\TestCase;

final class TextGeneratorExtendedTest extends TestCase
{
    private TextGenerator $generator;

    protected function setUp(): void
    {
        $config = [
            'text' => [
                'default_paragraphs' => 3,
                'default_sentences' => 5,
                'default_words' => 50,
            ],
        ];

        $this->generator = new TextGenerator($config);
    }

    public function testParagraphsWithDifferentCounts(): void
    {
        $text1 = $this->generator->paragraphs(1);
        $text5 = $this->generator->paragraphs(5);
        $text10 = $this->generator->paragraphs(10);

        $this->assertIsString($text1);
        $this->assertIsString($text5);
        $this->assertIsString($text10);

        // More paragraphs = more text
        $this->assertLessThan(\strlen($text5), \strlen($text1));
        $this->assertLessThan(\strlen($text10), \strlen($text5));

        // Check paragraph separators
        $this->assertSame(0, substr_count($text1, "\n\n"));
        $this->assertSame(4, substr_count($text5, "\n\n"));
        $this->assertSame(9, substr_count($text10, "\n\n"));
    }

    public function testSentencesWithDifferentCounts(): void
    {
        $text1 = $this->generator->sentences(1);
        $text5 = $this->generator->sentences(5);
        $text10 = $this->generator->sentences(10);

        $this->assertIsString($text1);
        $this->assertIsString($text5);
        $this->assertIsString($text10);

        // More sentences = more periods
        $this->assertGreaterThanOrEqual(1, substr_count($text1, '.'));
        $this->assertGreaterThanOrEqual(5, substr_count($text5, '.'));
        $this->assertGreaterThanOrEqual(10, substr_count($text10, '.'));
    }

    public function testWordsWithDifferentCounts(): void
    {
        $text10 = $this->generator->words(10);
        $text50 = $this->generator->words(50);
        $text100 = $this->generator->words(100);

        $this->assertIsString($text10);
        $this->assertIsString($text50);
        $this->assertIsString($text100);

        // Approximate word counts (may vary due to spaces)
        $this->assertLessThanOrEqual(15, str_word_count($text10));
        $this->assertGreaterThanOrEqual(40, str_word_count($text50));
        $this->assertGreaterThanOrEqual(90, str_word_count($text100));
    }

    public function testSentenceStartsWithCapital(): void
    {
        for ($i = 0; $i < 10; ++$i) {
            $sentence = $this->generator->sentence();

            $this->assertMatchesRegularExpression('/^[A-Z]/', $sentence);
            $this->assertStringEndsWith('.', $sentence);
        }
    }

    public function testTitleFormat(): void
    {
        for ($i = 0; $i < 10; ++$i) {
            $title = $this->generator->title();

            $this->assertIsString($title);
            $this->assertNotEmpty($title);

            // Should have 3-6 words
            $wordCount = str_word_count($title);
            $this->assertGreaterThanOrEqual(3, $wordCount);
            $this->assertLessThanOrEqual(6, $wordCount);

            // Each word should start with capital
            $words = explode(' ', $title);
            foreach ($words as $word) {
                $this->assertMatchesRegularExpression('/^[A-Z]/', $word);
            }
        }
    }

    public function testParagraphContainsMultipleSentences(): void
    {
        $paragraph = $this->generator->paragraph();

        // Should have at least 3 sentences (3 periods)
        $this->assertGreaterThanOrEqual(3, substr_count($paragraph, '.'));
    }

    public function testWordsAreFromLoremVocabulary(): void
    {
        $text = $this->generator->words(100);

        // Should contain some common Lorem Ipsum words
        $loremWords = ['lorem', 'ipsum', 'dolor', 'sit', 'amet', 'consectetur'];
        $containsLoremWord = false;

        foreach ($loremWords as $word) {
            if (str_contains(strtolower($text), $word)) {
                $containsLoremWord = true;

                break;
            }
        }

        $this->assertTrue($containsLoremWord);
    }
}
