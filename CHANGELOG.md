# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Added
- **UI Avatars provider** - Professional avatar generation with initials
- UI Avatars bold and rounded options

### Changed
- Switched avatar generation from Placeholder.com to UI Avatars (more reliable)
- Avatar generation now uses full names instead of just initials

### Removed
- **PlaceKitten provider** (service offline)
- **Placeholders.dev provider** (service offline)
- **Unsplash Source provider** (API deprecated by Unsplash)

## [0.1.0] - 2024-11-07

### Added
- Initial release
- Placeholder image generation with multiple providers:
  - Placeholder.com (default)
  - DummyImage.com
  - Picsum Photos (real photos)
  - PlaceKitten (cute kittens)
  - Placehold.co
  - Placeholders.dev
- Placeholder video generation:
  - LoremIpsum.video provider
  - 12 pre-built source ID clips (PowerPoint, Keynote, VT)
  - Custom video generation with duration, FPS, name, background
- Placeholder audio generation:
  - Silence provider (data URLs)
  - Custom sample rate and channels
  - WAV format (base64-encoded)
- Avatar generation with initials
- Lorem Ipsum text generation:
  - Paragraphs
  - Sentences
  - Words
  - Titles
- Faker integration for realistic fake data
- Twig functions for easy template usage
- Comprehensive configuration options
- PHPStan Level 9 compliance
- >85% test coverage (156 tests, 555 assertions)
- Complete documentation

### Features
- `placeholder_image()` - Generate placeholder images
- `placeholder_avatar()` - Generate avatars with initials
- `placeholder_video()` - Generate placeholder videos
- `placeholder_audio()` - Generate silent audio
- `lorem_paragraphs()` - Generate Lorem Ipsum paragraphs
- `lorem_paragraph()` - Generate single paragraph
- `lorem_sentences()` - Generate sentences
- `lorem_sentence()` - Generate single sentence
- `lorem_words()` - Generate words
- `lorem_title()` - Generate title
- `fake()` - Generate fake data using Faker

[Unreleased]: https://github.com/symfinity/omnia-ipsum/compare/v0.1.0...HEAD
[0.1.0]: https://github.com/symfinity/omnia-ipsum/releases/tag/v0.1.0

