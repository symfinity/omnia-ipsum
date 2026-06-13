<div align="center">

# Omnia Ipsum

### All-in-One Placeholder Text, Images, Audios and Videos for Symfony

[![PHP Version](https://img.shields.io/badge/PHP-8.1+-777BB4?style=flat&logo=php&logoColor=white)](composer.json)
[![Symfony](https://img.shields.io/badge/Symfony-6.4+-343434?style=flat&logo=symfony&logoColor=white)](composer.json)
<br/>
[![CI](https://github.com/symfinity/omnia-ipsum/actions/workflows/ci.yml/badge.svg)](https://github.com/symfinity/omnia-ipsum/actions/workflows/ci.yml)
<br/>
[![Release](https://img.shields.io/packagist/v/symfinity/omnia-ipsum.svg?style=flat&logo=packagist&logoColor=white)](https://packagist.org/packages/symfinity/omnia-ipsum)
[![Downloads](https://img.shields.io/packagist/dt/symfinity/omnia-ipsum.svg?style=flat&logo=packagist&logoColor=white)](https://packagist.org/packages/symfinity/omnia-ipsum)
[![License](https://img.shields.io/badge/license-MIT-blue.svg?style=flat)](LICENSE)

</div>

> [!NOTE]
> **Read-only mirror.** 
> See [CONTRIBUTING.md](CONTRIBUTING.md) for how to propose changes.

## Features
- **Placeholder Images** - 5 providers with real photos and colored placeholders
- **Avatar Generation** - Automatic initials and colors
- **Placeholder Videos** - Professional video clips
- **Placeholder Audio** - Music tracks and silent audio
- **Lorem Ipsum Text** - Classic placeholder text generation
- **Fake Data** - FakerPHP integration for realistic content
- **Twig Functions** - Simple, intuitive template functions

## Prerequisites

Add the [symfinity/recipes](https://github.com/symfinity/recipes) Flex endpoint to your project's `composer.json` (see [recipes README](https://github.com/symfinity/recipes/blob/main/README.md)) — recipes are not in Symfony's official recipe repository yet.

## Installation
```bash
composer require symfinity/omnia-ipsum
```

The Flex recipe registers the bundle for **dev** and **test** only. **Do not enable in production** — see [Installation](docs/installation.md).

## Documentation
- **[Quickstart](docs/quickstart.md)** - Get started in 5 minutes
- **[Installation](docs/installation.md)** - Flex, manual setup, environments
- **[Image Providers](docs/images.md)** - All image providers and options
- **[Video Providers](docs/videos.md)** - Video options and clips
- **[Audio Providers](docs/audios.md)** - Audio providers and tracks
- **[Text Generation](docs/text.md)** - Lorem Ipsum and Faker integration
- **[Faker Integration](docs/faker.md)** - All available fake data formatters
- **[Configuration](docs/configuration.md)** - Configuration options

## Requirements
- PHP 8.1 or higher
- Symfony 6.4, 7.x, or 8.x
- Twig 3.0 or higher

## Support
- [GitHub Issues](https://github.com/symfinity/omnia-ipsum/issues)
- [Security](.github/SECURITY.md)
- [Contributing](CONTRIBUTING.md)

## License
[MIT](LICENSE)
