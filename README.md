<div align="center">

# Omnia Ipsum

### All-in-One Placeholder Text, Images, Audios and Videos for Symfony

[![PHP Version](https://img.shields.io/badge/PHP-8.2+-777BB4?style=flat&logo=php&logoColor=white)](composer.json)
[![Symfony](https://img.shields.io/badge/Symfony-7.4+-343434?style=flat&logo=symfony&logoColor=white)](composer.json)
[![License](https://img.shields.io/badge/license-MIT-blue.svg?style=flat)](LICENSE)

</div>

## Features

- **Placeholder Images** - 5 providers (Picsum, Placeholder.com, DummyImage, Placehold.co, UI Avatars)
- **Avatar Generation** - UI Avatars with automatic initials and colors
- **Placeholder Videos** - Google Cloud Storage with 13 professional videos
- **Placeholder Audio** - Silent WAV generation (data URLs)
- **Lorem Ipsum Text** - Paragraphs, sentences, words, titles
- **Fake Data** - FakerPHP integration for realistic data (with `fake_text()` for realistic content)
- **Twig Functions** - Simple, intuitive template functions (Runtime-based architecture)

## Installation

```bash
composer require symfinity/omnia-ipsum
```

## Quick Start

### 1. Use in templates

```twig
{# Images #}
<img src="{{ omnia_image(600, 400) }}" alt="Placeholder">
<img src="{{ omnia_image(800, 600, {provider: 'picsum'}) }}" alt="Photo">
<img src="{{ omnia_avatar('John Doe', 100) }}" alt="Avatar">

{# Videos #}
<video src="{{ omnia_video(1920, 1080, {video: 'sintel'}) }}" controls></video>

{# Audio #}
<audio src="{{ omnia_audio(10) }}" controls></audio>

{# Text #}
<h1>{{ lorem_title() }}</h1>
<p>{{ lorem_paragraphs(3) }}</p>

{# Fake Data #}
<p>{{ fake('name') }} - {{ fake('email') }}</p>
<p>{{ fake_text(200) }}</p> {# Realistic text instead of Lorem Ipsum #}
```

### 2. Configure (optional)

```yaml
# config/packages/omnia_ipsum.yaml
omnia_ipsum:
    images:
        default_provider: 'picsum'
    faker:
        locale: 'de_DE'
```

### 3. Disable in production

```php
// config/bundles.php
return [
    // ...
    Symfinity\OmniaIpsum\OmniaIpsumBundle::class => ['dev' => true, 'test' => true],
];
```

## Console Commands

```bash
# List all available providers
php bin/console omnia:list-providers

# Test all providers for availability
php bin/console omnia:test-providers

# Validate configuration
php bin/console omnia:validate
```

## Documentation

- **[Quick Reference](docs/quickstart.md)** - Get started in 5 minutes
- **[Console Commands](docs/commands.md)** - Provider management and testing
- **[Image Providers](docs/images.md)** - 5 providers including Picsum, Placeholder.com, UI Avatars
- **[Video Providers](docs/videos.md)** - Google Cloud Storage (13 videos)
- **[Audio Providers](docs/audios.md)** - Silent audio generation
- **[Text Generation](docs/text.md)** - Lorem Ipsum + Faker realistic text
- **[Configuration](docs/configuration.md)** - All configuration options

## Requirements

- PHP 8.2 or higher
- Symfony 7.4 LTS (see `composer.json` for component constraints)
- Twig 3.0 or higher

## Migration from neuralglitch/omnia-ipsum

See **[docs/migration.md](docs/migration.md)** for namespace, bundle class, Composer name, and Symfony floor changes.

## Support

- [GitHub Issues](https://github.com/symfinity/omnia-ipsum/issues)
- [Security](.github/SECURITY.md)
- [Contributing](CONTRIBUTING.md)

## License

[MIT](LICENSE)