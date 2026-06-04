# Configuration

Complete configuration reference for Omnia Ipsum.

## Default Configuration

```yaml
# config/packages/omnia_ipsum.yaml
omnia_ipsum:
    # Image settings
    images:
        default_provider: 'placeholder'  # Default image provider
        default_width: 600               # Default width in pixels
        default_height: 400              # Default height in pixels
        default_background: 'cccccc'     # Default background color (hex, no #)
        default_foreground: '333333'     # Default foreground/text color (hex, no #)
        default_text: null               # Default text (null = dimensions)

    # Video settings
    videos:
        default_provider: 'gcs'          # Default video provider
        default_width: 1920              # Default width in pixels (1-3840)
        default_height: 1080             # Default height in pixels (1-2160)
        default_duration: 30             # Default duration in seconds (1-120)

    # Audio settings
    audios:
        default_provider: 'silence'      # Default audio provider
        default_duration: 10             # Default duration in seconds (1-60)

    # Lorem Ipsum text settings
    text:
        default_paragraphs: 3            # Default number of paragraphs
        default_sentences: 5             # Default number of sentences
        default_words: 50                # Default number of words

    # Faker settings
    faker:
        locale: 'en_US'                  # Faker locale (e.g., de_DE, fr_FR, en_US)
        seed: null                       # Seed for reproducible fake data (null = random)
```

## Image Configuration

### Default Provider

Choose your preferred default image provider:

```yaml
omnia_ipsum:
    images:
        default_provider: 'picsum'  # Use Picsum Photos by default
```

**Available providers:** `placeholder`, `dummyimage`, `picsum`, `placehold`, `ui-avatars`

### Default Dimensions

Set default dimensions for all placeholder images:

```yaml
omnia_ipsum:
    images:
        default_width: 1200   # Wider images by default
        default_height: 800   # Taller images by default
```

### Default Colors

Set default colors (hex, without #):

```yaml
omnia_ipsum:
    images:
        default_background: '007bff'  # Blue background
        default_foreground: 'ffffff'  # White text
```

### Default Text

Set default text for placeholders:

```yaml
omnia_ipsum:
    images:
        default_text: 'Preview Image'  # Custom default text
```

## Text Configuration

### Lorem Ipsum Defaults

```yaml
omnia_ipsum:
    text:
        default_paragraphs: 5   # Longer default content
        default_sentences: 10   # More sentences
        default_words: 100      # More words
```

## Faker Configuration

### Locale

Change the Faker locale for localized fake data:

```yaml
omnia_ipsum:
    faker:
        locale: 'de_DE'  # German fake data
```

**Popular locales:**
- `en_US` - English (US)
- `en_GB` - English (UK)
- `de_DE` - German
- `fr_FR` - French
- `es_ES` - Spanish
- `it_IT` - Italian
- `nl_NL` - Dutch
- `pt_BR` - Portuguese (Brazil)
- `ja_JP` - Japanese
- `zh_CN` - Chinese

### Seed (Reproducible Data)

Set a seed for consistent fake data across page loads:

```yaml
omnia_ipsum:
    faker:
        seed: 42  # Always generate the same fake data
```

**Use cases:**
- Screenshot testing (consistent data)
- Demo environments (same data every time)
- Development (predictable output)

**For production prototypes, leave seed as `null` for variety.**

## Environment-Specific Configuration

### Development

```yaml
# config/packages/dev/omnia_ipsum.yaml
omnia_ipsum:
    images:
        default_provider: 'picsum'  # Real photos in dev
    faker:
        seed: 42  # Consistent data for screenshots
```

### Testing

```yaml
# config/packages/test/omnia_ipsum.yaml
omnia_ipsum:
    faker:
        seed: 12345  # Reproducible test data
```

### Production

```yaml
# config/packages/prod/omnia_ipsum.yaml
# Disable or remove bundle in production!
```

## Complete Example

```yaml
# config/packages/omnia_ipsum.yaml
omnia_ipsum:
    images:
        default_provider: 'picsum'
        default_width: 1200
        default_height: 800
        default_background: '007bff'
        default_foreground: 'ffffff'
        default_text: 'Preview'

    text:
        default_paragraphs: 5
        default_sentences: 10
        default_words: 100

    faker:
        locale: 'en_US'
        seed: null  # Random data
```

## Overriding in Templates

You can always override configuration in templates:

```twig
{# Override default provider #}
{{ omnia_image(800, 600, {provider: 'picsum'}) }}

{# Override default colors #}
{{ omnia_image(600, 400, {
    background: 'ff0000',
    foreground: '000000'
}) }}

{# Override default paragraph count #}
{{ lorem_paragraphs(10) }}

{# Override Faker locale #}
{# Not directly possible - set in config #}
```

## Disabling in Production

**Important:** This bundle is intended for development and prototyping only!

### Option 1: Bundle Condition

```php
// config/bundles.php
return [
    // ...
    Symfinity\OmniaIpsum\OmniaIpsumBundle::class => ['dev' => true, 'test' => true],
];
```

### Option 2: Twig Condition

```twig
{% if app.environment != 'prod' %}
    <img src="{{ omnia_image(600, 400) }}" alt="Placeholder">
{% else %}
    <img src="{{ real_image_path }}" alt="Real Image">
{% endif %}
```

### Option 3: Service Condition

```yaml
# config/services.yaml
services:
    _defaults:
        autowire: true
        autoconfigure: true

when@prod:
    # Disable OmniaIpsum services in production
    Symfinity\OmniaIpsum\:
        resource: '../vendor/symfinity/omnia-ipsum/src/*'
        exclude:
            - '../vendor/symfinity/omnia-ipsum/src/**'
```

## Configuration Validation

Validate your configuration using the console command:

```bash
php bin/console omnia:validate
```

The bundle also validates configuration automatically:

```yaml
# ❌ Invalid: Width too large
omnia_ipsum:
    images:
        default_width: 10000  # Max: 5000
```

**Valid ranges:**
- `default_width`: 1-5000
- `default_height`: 1-5000
- `default_paragraphs`: 1-100
- `default_sentences`: 1-100
- `default_words`: 1-1000

## See Also

- [Console Commands](commands.md) - Provider management and testing
- [Quick Reference](quickstart.md) - How to use in templates
- [Image Providers](images.md) - Available providers
- [Faker Integration](faker.md) - Faker formatters
