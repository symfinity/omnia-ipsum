<?php

declare(strict_types=1);

namespace Symfinity\OmniaIpsum\Twig\Runtime;

use Symfinity\OmniaIpsum\Service\TextGenerator;
use Twig\Extension\RuntimeExtensionInterface;

final class TextRuntime implements RuntimeExtensionInterface
{
    public function __construct(
        private readonly TextGenerator $textGenerator,
    ) {
    }

    /**
     * Generate Lorem Ipsum paragraphs.
     */
    public function loremParagraphs(int $count = 3): string
    {
        return $this->textGenerator->paragraphs($count);
    }

    /**
     * Generate a single Lorem Ipsum paragraph.
     */
    public function loremParagraph(): string
    {
        return $this->textGenerator->paragraph();
    }

    /**
     * Generate Lorem Ipsum sentences.
     */
    public function loremSentences(int $count = 5): string
    {
        return $this->textGenerator->sentences($count);
    }

    /**
     * Generate a single Lorem Ipsum sentence.
     */
    public function loremSentence(): string
    {
        return $this->textGenerator->sentence();
    }

    /**
     * Generate Lorem Ipsum words.
     */
    public function loremWords(int $count = 50): string
    {
        return $this->textGenerator->words($count);
    }

    /**
     * Generate a Lorem Ipsum title.
     */
    public function loremTitle(): string
    {
        return $this->textGenerator->title();
    }
}
