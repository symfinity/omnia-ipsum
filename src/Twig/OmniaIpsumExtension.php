<?php

declare(strict_types=1);

namespace Symfinity\OmniaIpsum\Twig;

use Symfinity\OmniaIpsum\Twig\Runtime\AudioRuntime;
use Symfinity\OmniaIpsum\Twig\Runtime\FakerRuntime;
use Symfinity\OmniaIpsum\Twig\Runtime\ImageRuntime;
use Symfinity\OmniaIpsum\Twig\Runtime\TextRuntime;
use Symfinity\OmniaIpsum\Twig\Runtime\VideoRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class OmniaIpsumExtension extends AbstractExtension
{
    /**
     * @return array<TwigFunction>
     */
    public function getFunctions(): array
    {
        return [
            // Image functions
            new TwigFunction('omnia_image', [ImageRuntime::class, 'omniaImage']),
            new TwigFunction('omnia_avatar', [ImageRuntime::class, 'omniaAvatar']),

            // Video functions
            new TwigFunction('omnia_video', [VideoRuntime::class, 'omniaVideo']),

            // Audio functions
            new TwigFunction('omnia_audio', [AudioRuntime::class, 'omniaAudio']),

            // Lorem Ipsum text functions
            new TwigFunction('lorem_paragraphs', [TextRuntime::class, 'loremParagraphs']),
            new TwigFunction('lorem_paragraph', [TextRuntime::class, 'loremParagraph']),
            new TwigFunction('lorem_sentences', [TextRuntime::class, 'loremSentences']),
            new TwigFunction('lorem_sentence', [TextRuntime::class, 'loremSentence']),
            new TwigFunction('lorem_words', [TextRuntime::class, 'loremWords']),
            new TwigFunction('lorem_title', [TextRuntime::class, 'loremTitle']),

            // Faker functions
            new TwigFunction('fake', [FakerRuntime::class, 'fake']),
            new TwigFunction('fake_text', [FakerRuntime::class, 'fakeText']),
        ];
    }
}
