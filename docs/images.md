# Image Providers

Complete reference for all available placeholder image providers.

## Provider Comparison

| Provider | Real Photos | Custom Text | Custom Colors | Formats | Special Features |
|----------|-------------|-------------|---------------|---------|------------------|
| `picsum` | ✅ | ❌ | ❌ | JPG | **Default**, random photos, grayscale, blur, seed |
| `placeholder` | ❌ | ✅ | ✅ | PNG, JPG, GIF | Fast, simple |
| `dummyimage` | ❌ | ✅ | ✅ | PNG, JPG, GIF | Multiple formats |
| `placehold` | ❌ | ✅ | ✅ | PNG, JPG, GIF, WebP | Modern API, WebP support |
| `ui-avatars` | ❌ | ✅ | ✅ | PNG, SVG | **Avatars with initials**, rounded, bold |

## Placeholder.com (Default)

**URL Pattern:** `https://via.placeholder.com/{width}x{height}/{bg}/{fg}?text={text}`

### Supported Options

- `background` - Background color (hex, no #)
- `foreground` - Text color (hex, no #)
- `text` - Custom text

### Examples

```twig
{# Basic #}
{{ omnia_image(600, 400) }}

{# Custom colors #}
{{ omnia_image(600, 400, {
    background: 'ff6b6b',
    foreground: 'ffffff'
}) }}

{# With text #}
{{ omnia_image(800, 600, {
    text: 'Product Image'
}) }}
```

## DummyImage.com

**URL Pattern:** `https://dummyimage.com/{width}x{height}/{bg}/{fg}.{format}&text={text}`

### Supported Options

- `background` - Background color (hex, no #)
- `foreground` - Text color (hex, no #)
- `text` - Custom text
- `format` - Image format (`png`, `jpg`, `gif`)

### Examples

```twig
{# JPEG format #}
{{ omnia_image(800, 600, {
    provider: 'dummyimage',
    format: 'jpg'
}) }}

{# Custom everything #}
{{ omnia_image(1200, 800, {
    provider: 'dummyimage',
    background: '007bff',
    foreground: 'ffffff',
    text: 'Hero Image',
    format: 'png'
}) }}
```

## Picsum Photos (Lorem Picsum)

**URL Pattern:** `https://picsum.photos/{width}/{height}?grayscale&blur={level}`

Random photos with special effects. Good for general use.

### Supported Options

- `grayscale` - Convert to grayscale (boolean)
- `blur` - Blur level (1-10)
- `seed` - Seed for consistent random image (integer)

### Examples

```twig
{# Random photo #}
{{ omnia_image(800, 600, {provider: 'picsum'}) }}

{# Grayscale #}
{{ omnia_image(800, 600, {
    provider: 'picsum',
    grayscale: true
}) }}

{# Blurred #}
{{ omnia_image(1920, 1080, {
    provider: 'picsum',
    blur: 5
}) }}

{# Consistent image (same seed = same image) #}
{{ omnia_image(600, 400, {
    provider: 'picsum',
    seed: 42
}) }}
```

### Best For

- Hero images
- Background images
- Gallery mockups
- Realistic prototypes

## PlaceKitten

**URL Pattern:** `https://placekitten.com/{width}/{height}` or `https://placekitten.com/g/{width}/{height}`

Cute kitten photos. Great for fun projects or pet-related sites.

### Supported Options

- `grayscale` - Convert to grayscale (boolean)

### Examples

```twig
{# Random kitten #}
{{ omnia_image(400, 300, {provider: 'placekitten'}) }}

{# Grayscale kitten #}
{{ omnia_image(400, 300, {
    provider: 'placekitten',
    grayscale: true
}) }}
```

### Best For

- Pet websites
- Fun prototypes
- Children's apps
- Playful designs

## Placehold.co

**URL Pattern:** `https://placehold.co/{width}x{height}/{bg}/{fg}.{format}?text={text}`

Modern placeholder service with clean design.

### Supported Options

- `background` - Background color (hex, no #)
- `foreground` - Text color (hex, no #)
- `text` - Custom text
- `format` - Image format (`png`, `jpg`, `gif`, `webp`)

### Examples

```twig
{# Basic #}
{{ omnia_image(600, 400, {provider: 'placehold'}) }}

{# WebP format #}
{{ omnia_image(800, 600, {
    provider: 'placehold',
    format: 'webp'
}) }}
```

## Placeholders.dev

**URL Pattern:** `https://placeholders.dev/{width}x{height}/{bg}/{fg}?text={text}`

Simple and fast placeholder service.

### Supported Options

- `background` - Background color (hex, no #)
- `foreground` - Text color (hex, no #)
- `text` - Custom text

### Examples

```twig
{# Basic #}
{{ omnia_image(600, 400, {provider: 'placeholders'}) }}

{# Custom #}
{{ omnia_image(800, 600, {
    provider: 'placeholders',
    background: '28a745',
    foreground: 'ffffff',
    text: 'Success!'
}) }}
```

## UI Avatars (Avatar Generation)

**URL Pattern:** `https://ui-avatars.com/api/?name={name}&size={size}`

Specialized service for generating avatar images with initials and colors.

### Supported Options

- `name` - Full name to generate initials from (required)
- `background` - Background color (hex, no #)
- `foreground` - Text color (hex, no #)
- `bold` - Bold text (boolean)
- `rounded` - Rounded avatar (boolean)

### Examples

```twig
{# Basic avatar with automatic initials #}
<img src="{{ omnia_avatar('John Doe', 100) }}" alt="John Doe" class="rounded-circle">

{# With custom colors #}
<img src="{{ omnia_avatar('Jane Smith', 80, {
    background: '007bff',
    foreground: 'ffffff'
}) }}" alt="Jane Smith">

{# Bold and rounded #}
<img src="{{ omnia_avatar('Bob Wilson', 120, {
    bold: true,
    rounded: true
}) }}" alt="Bob Wilson">
```

### Features

- **Automatic Initials**: Extracts initials from full name (e.g., "John Doe" → "JD")
- **Consistent Colors**: Same name always generates same color
- **Custom Colors**: Override with custom background/foreground
- **SVG Support**: Lightweight vector format
- **Fast CDN**: Delivered via global CDN

### Best For

- User profiles
- Team member lists
- Comment sections
- Contact lists
- Author bylines

## Choosing the Right Provider

### Use `ui-avatars` when:
- Generating user avatars
- Need initials displayed
- Want consistent colors per name
- Building team/profile pages

### Use `picsum` when:
- You want realistic photos
- You're building a gallery
- You need hero images
- You want to impress clients
- Need blur or grayscale effects

### Use `placeholder` (default) when:
- You need simple colored boxes
- You want fast loading
- You need custom text
- You're prototyping layouts

### Use `dummyimage` when:
- You need specific image formats
- You want fine control over colors
- You need consistent styling
- You're testing image optimization

### Use `placehold` when:
- You want WebP format
- You need modern placeholder API
- You want colored boxes with text

## Custom Provider

You can create custom providers by implementing `ImageProviderInterface`:

```php
<?php

declare(strict_types=1);

namespace App\Provider;

use Symfinity\OmniaIpsum\Provider\ImageProviderInterface;

final class CustomProvider implements ImageProviderInterface
{
    public function generate(int $width, int $height, array $options = []): string
    {
        return sprintf('https://example.com/%dx%d', $width, $height);
    }

    public function getName(): string
    {
        return 'custom';
    }

    public function supportsOption(string $option): bool
    {
        return in_array($option, ['format', 'quality'], true);
    }
}
```

Register in `config/services.yaml`:

```yaml
services:
    App\Provider\CustomProvider:
        tags:
            - { name: 'omnia_ipsum.image_provider' }
```

Use in templates:

```twig
{{ omnia_image(800, 600, {provider: 'custom'}) }}
```

## Provider Performance

| Provider | Avg. Load Time | CDN | Rate Limit |
|----------|----------------|-----|------------|
| `placeholder` | ~100ms | ✅ | None |
| `dummyimage` | ~120ms | ✅ | None |
| `picsum` | ~200ms | ✅ | None |
| `placekitten` | ~180ms | ✅ | None |
| `placehold` | ~110ms | ✅ | None |
| `placeholders` | ~100ms | ✅ | None |

*Times measured from Europe, may vary by region*

## See Also

- [Usage Guide](usage.md) - How to use images in templates
- [Configuration](configuration.md) - Set default provider
