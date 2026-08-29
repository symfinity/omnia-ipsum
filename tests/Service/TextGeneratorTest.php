<?php

declare(strict_types=1);

namespace Symfinity\OmniaIpsum\Tests\Service;

use Symfinity\OmniaIpsum\Service\TextGenerator;
use PHPUnit\Framework\TestCase;

final class TextGeneratorTest extends TestCase
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

    public function testParagraphs(): void
    {
        $text = $this->generator->paragraphs(3);

        $this->assertIsString($text);
        $this->assertNotEmpty($text);
        $this->assertStringContainsString("\n\n", $text);
    }

    public function testParagraph(): void
    {
        $text = $this->generator->paragraph();

        $this->assertIsString($text);
        $this->assertNotEmpty($text);
        $this->assertStringContainsString('.', $text);
    }

    public function testSentences(): void
    {
        $text = $this->generator->sentences(5);

        $this->assertIsString($text);
        $this->assertNotEmpty($text);
        $this->assertGreaterThan(3, substr_count($text, '.'));
    }

    public function testSentence(): void
    {
        $text = $this->generator->sentence();

        $this->assertIsString($text);
        $this->assertNotEmpty($text);
        $this->assertStringEndsWith('.', $text);
    }

    public function testWords(): void
    {
        $text = $this->generator->words(50);

        $this->assertIsString($text);
        $this->assertNotEmpty($text);
        $this->assertGreaterThan(30, str_word_count($text));
    }

    public function testTitle(): void
    {
        $text = $this->generator->title();

        $this->assertIsString($text);
        $this->assertNotEmpty($text);
        $this->assertMatchesRegularExpression('/^[A-Z]/', $text);
    }
}
