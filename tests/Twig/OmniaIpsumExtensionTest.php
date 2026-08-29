<?php

declare(strict_types=1);

namespace Symfinity\OmniaIpsum\Tests\Twig;

use Symfinity\OmniaIpsum\Twig\OmniaIpsumExtension;
use PHPUnit\Framework\TestCase;

final class OmniaIpsumExtensionTest extends TestCase
{
    private OmniaIpsumExtension $extension;

    protected function setUp(): void
    {
        $this->extension = new OmniaIpsumExtension();
    }

    public function testGetFunctions(): void
    {
        $functions = $this->extension->getFunctions();

        $this->assertIsArray($functions);
        $this->assertNotEmpty($functions);
        $this->assertCount(12, $functions); // 12 functions: image(2), video(1), audio(1), text(6), faker(2)
    }

    public function testFunctionNamesAreCorrect(): void
    {
        $functions = $this->extension->getFunctions();
        $names = array_map(fn ($f) => $f->getName(), $functions);

        $this->assertContains('omnia_image', $names);
        $this->assertContains('omnia_avatar', $names);
        $this->assertContains('omnia_video', $names);
        $this->assertContains('omnia_audio', $names);
        $this->assertContains('lorem_paragraphs', $names);
        $this->assertContains('lorem_paragraph', $names);
        $this->assertContains('lorem_sentences', $names);
        $this->assertContains('lorem_sentence', $names);
        $this->assertContains('lorem_words', $names);
        $this->assertContains('lorem_title', $names);
        $this->assertContains('fake', $names);
        $this->assertContains('fake_text', $names);
    }
}
