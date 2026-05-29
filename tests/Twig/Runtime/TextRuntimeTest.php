<?php

declare(strict_types=1);

namespace Symfinity\OmniaIpsum\Tests\Twig\Runtime;

use Symfinity\OmniaIpsum\Service\TextGenerator;
use Symfinity\OmniaIpsum\Twig\Runtime\TextRuntime;
use PHPUnit\Framework\TestCase;

final class TextRuntimeTest extends TestCase
{
    private TextRuntime $runtime;

    protected function setUp(): void
    {
        $config = [
            'text' => [
                'default_paragraphs' => 3,
            ],
        ];

        $textGenerator = new TextGenerator($config);
        $this->runtime = new TextRuntime($textGenerator);
    }

    public function testLoremParagraphs(): void
    {
        $text = $this->runtime->loremParagraphs(3);

        $this->assertIsString($text);
        $this->assertNotEmpty($text);
    }

    public function testLoremParagraph(): void
    {
        $text = $this->runtime->loremParagraph();

        $this->assertIsString($text);
        $this->assertNotEmpty($text);
    }

    public function testLoremSentences(): void
    {
        $text = $this->runtime->loremSentences(5);

        $this->assertIsString($text);
        $this->assertNotEmpty($text);
    }

    public function testLoremSentence(): void
    {
        $text = $this->runtime->loremSentence();

        $this->assertIsString($text);
        $this->assertNotEmpty($text);
    }

    public function testLoremWords(): void
    {
        $text = $this->runtime->loremWords(50);

        $this->assertIsString($text);
        $this->assertNotEmpty($text);
    }

    public function testLoremTitle(): void
    {
        $text = $this->runtime->loremTitle();

        $this->assertIsString($text);
        $this->assertNotEmpty($text);
    }
}
