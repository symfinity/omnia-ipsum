# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [0.1.1] - 2026-06-12

### Changed

- Relocated to `symfinity/omnia-ipsum` under the Symfinity organization; namespace `NeuralGlitch\OmniaIpsum\` → `Symfinity\OmniaIpsum\` (no functional changes in this release).

### Notes

- CI on the split mirror: PHP 8.1 × Symfony 6.4.* only (relocation). Broader matrix including Symfony 7.4 and 8.1 (PHP 8.4+) planned for the next patch; Symfony 8.0 not targeted (EOL July 2026).

## [0.1.0] - 2025-11-08

### Added

- Initial release of Omnia Ipsum Bundle for Symfony
- Twig functions for easy placeholder integration in templates
- Image providers (5 total): Picsum Photos (default), Placeholder.com, DummyImage, Placehold.co, UI Avatars
- Video provider: Google Cloud Storage with 13 professional videos (Big Buck Bunny, Sintel, Elephants Dream, etc.)
- Audio providers (2 total): SoundHelix generated music (default), Silence for testing
- Lorem Ipsum text generation (paragraphs, sentences, words, titles)
- Faker integration with 100+ formatters for realistic fake data
- `fake_text()` function for realistic content (alternative to Lorem Ipsum)
- Configuration system for all providers and generators
- 12 Twig functions:
  - `omnia_image()`, `omnia_avatar()`
  - `omnia_video()`
  - `omnia_audio()`
  - `lorem_paragraphs()`, `lorem_paragraph()`, `lorem_sentences()`, `lorem_sentence()`, `lorem_words()`, `lorem_title()`
  - `fake()`, `fake_text()`
- Picsum `seed` parameter for different images in loops
- SoundHelix music tracks (10 songs, ~5 minutes each)
- UI Avatars with automatic initials and color generation
- Symfony 6.4, 7.x, and 8.x compatibility
- Documentation with detailed guides for all features
- Demo application showcasing all features
