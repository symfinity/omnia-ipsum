# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [0.1.4] - 2026-06-24

### Changed

- README: installation command uses `composer require --dev` to match dev/test-only Flex registration

### Notes

- No functional or API changes — documentation patch only

## [0.1.3] - 2026-06-22

### Changed

- Symfony configuration root key: `omnia_ipsum:` → `symfinity_omnia_ipsum:` (Symfinity bundle config naming)
- Default config file: `config/packages/symfinity_omnia_ipsum.yaml` (Flex recipe and package default)
- Handbook: configuration examples use `when@dev` / `when@test` in a single config file; migration table updated

### Notes

- Twig function names are unchanged (`omnia_image`, `lorem_paragraphs`, `fake`, etc.)
- Upgrading from 0.1.2: rename your config file and root key, or re-apply the Flex recipe — see [docs/upgrade.md](docs/upgrade.md)

## [0.1.2] - 2026-06-14

### Changed

- Split mirror CI expanded to PHP 8.2–8.5 × Symfony 6.4, 7.4, 8.0, and 8.1 (PHPUnit + PHPStan on every cell)
- Handbook: consumer upgrade guide, index cleanup, quickstart cross-links and support footer
- Packagist archives slimmed via `.gitattributes` `export-ignore` rules

### Notes

- No functional or API changes — patch release following the 0.1.1 relocation note
- Symfony 8.0 remains in the CI matrix for compatibility; prefer 8.1+ for new projects

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
