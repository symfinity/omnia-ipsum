# Quick Reference

Get started with Omnia Ipsum in 5 minutes.

## Installation

```bash
composer require symfinity/omnia-ipsum
```

Bundle is auto-registered via Symfony Flex (dev and test environments only).

Migrating from `neuralglitch/omnia-ipsum`? See [migration.md](migration.md).

## All Functions at a Glance

```twig
{# Images (5 providers) #}
{{ omnia_image(width, height, options) }}
{{ omnia_avatar(name, size, options) }}

{# Videos (Google Cloud Storage) #}
{{ omnia_video(width, height, options) }}

{# Audio (Silent WAV) #}
{{ omnia_audio(duration, options) }}

{# Lorem Ipsum Text #}
{{ lorem_paragraphs(count) }}
{{ lorem_paragraph() }}
{{ lorem_sentences(count) }}
{{ lorem_sentence() }}
{{ lorem_words(count) }}
{{ lorem_title() }}

{# Faker (Realistic Data) #}
{{ fake(formatter, arguments) }}
```

## Common Examples

### Hero Section

```twig
<section class="hero">
    <video src="{{ omnia_video(1920, 1080, {clip: 'powerpoint-1'}) }}" 
           autoplay muted loop class="hero-video"></video>
    <div class="hero-content">
        <h1>{{ lorem_title() }}</h1>
        <p>{{ lorem_sentence() }}</p>
    </div>
</section>
```

### Product Grid

```twig
<div class="product-grid">
    {% for i in 1..12 %}
        <div class="product-card">
            <img src="{{ omnia_image(300, 300, {provider: 'picsum'}) }}" alt="Product">
            <h3>{{ lorem_title() }}</h3>
            <p>{{ lorem_sentence() }}</p>
            <p class="price">{{ fake('randomFloat', [2, 10, 1000]) }} €</p>
        </div>
    {% endfor %}
</div>
```

### Team Section

```twig
<div class="team">
    {% for i in 1..6 %}
        {% set name = fake('name') %}
        <div class="team-member">
            <img src="{{ omnia_avatar(name, 120) }}" alt="{{ name }}">
            <h4>{{ name }}</h4>
            <p>{{ fake('jobTitle') }}</p>
            <p>{{ fake('email') }}</p>
        </div>
    {% endfor %}
</div>
```

### Blog Post

```twig
<article>
    <img src="{{ omnia_image(1200, 400, {provider: 'picsum'}) }}" class="featured">
    <h1>{{ lorem_title() }}</h1>
    <div class="meta">
        {% set author = fake('name') %}
        <img src="{{ omnia_avatar(author, 40) }}" alt="{{ author }}">
        <span>{{ author }}</span>
        <time>{{ fake('dateTimeBetween', ['-30 days', 'now'])|date('F j, Y') }}</time>
    </div>
    <div class="content">{{ lorem_paragraphs(5) }}</div>
</article>
```

### Media Gallery

```twig
<div class="gallery">
    {# Images #}
    {% for i in 1..6 %}
        <img src="{{ omnia_image(400, 300, {provider: 'picsum'}) }}">
    {% endfor %}
    
    {# Videos #}
    {% for i in 1..3 %}
        <video src="{{ omnia_video(800, 600, {duration: 15}) }}" controls></video>
    {% endfor %}
    
    {# Audio #}
    {% for i in 1..3 %}
        <div class="audio-item">
            <h4>{{ lorem_title() }}</h4>
            <audio src="{{ omnia_audio(30) }}" controls></audio>
        </div>
    {% endfor %}
</div>
```

## Image Providers

```twig
{# Picsum - Real photos #}
{{ omnia_image(800, 600, {provider: 'picsum'}) }}

{# Picsum - Grayscale or blurred #}
{{ omnia_image(800, 600, {provider: 'picsum', grayscale: true}) }}
{{ omnia_image(800, 600, {provider: 'picsum', blur: 5}) }}

{# Placeholder.com - Colored boxes (default) #}
{{ omnia_image(600, 400, {background: 'ff0000', text: 'Sale!'}) }}

{# DummyImage - Multiple formats #}
{{ omnia_image(800, 600, {provider: 'dummyimage', format: 'jpg'}) }}

{# UI Avatars - User avatars #}
{{ omnia_avatar('John Doe', 100) }}
```

**See [Image Providers](images.md) for all 5 providers.**

## Video Clips

```twig
{# Pre-built clips (CFR, professional quality) #}
{{ omnia_video(1920, 1080, {clip: 'powerpoint-1'}) }}
{{ omnia_video(1920, 1080, {clip: 'keynote-2'}) }}
{{ omnia_video(1920, 1080, {clip: 'vt-3'}) }}

{# Custom videos #}
{{ omnia_video(1280, 720, {duration: 30, name: 'Demo'}) }}
```

**12 clips available:** powerpoint-1 to 4, keynote-1 to 4, vt-1 to 4

**See [Video Providers](videos.md) for details.**

## Faker Formatters

```twig
{# Personal #}
{{ fake('name') }}
{{ fake('email') }}
{{ fake('phoneNumber') }}

{# Address #}
{{ fake('address') }}
{{ fake('city') }}
{{ fake('country') }}

{# Company #}
{{ fake('company') }}
{{ fake('jobTitle') }}

{# Internet #}
{{ fake('userName') }}
{{ fake('url') }}

{# Dates #}
{{ fake('date') }}
{{ fake('dateTime')|date('Y-m-d H:i') }}

{# Numbers #}
{{ fake('randomNumber') }}
{{ fake('randomFloat', [2, 0, 100]) }}

{# Text #}
{{ fake('sentence') }}
{{ fake('paragraph') }}
```

**See [Faker Integration](faker.md) for 100+ formatters.**

## Configuration

```yaml
# config/packages/omnia_ipsum.yaml
omnia_ipsum:
    images:
        default_provider: 'picsum'      # Default image provider
        
    videos:
        default_duration: 30            # Default video duration (seconds)
        
    faker:
        locale: 'de_DE'                 # German fake data
        seed: 42                        # Reproducible data
```

**See [Configuration](configuration.md) for all options.**

## Best Practices

### ✅ DO

- Use in development/testing only
- Disable in production (`['dev' => true, 'test' => true]`)
- Choose appropriate providers (Picsum for photos, PlaceKitten for fun)
- Use pre-built video clips for better performance
- Keep audio duration short (<30s)

### ❌ DON'T

- Don't use in production
- Don't generate long audio (>60s causes memory issues)
- Don't rely on data URLs for large files
- Don't use Faker for passwords/tokens

## Next Steps

- **[Image Providers](images.md)** - Learn about all image providers
- **[Video Providers](videos.md)** - Video options and clips
- **[Faker Integration](faker.md)** - All available fake data formatters
- **[Configuration](configuration.md)** - Customize defaults

## See Also

- [CHANGELOG.md](../CHANGELOG.md) - Version history
- [CONTRIBUTING.md](../CONTRIBUTING.md) - How to contribute
- [GitHub Issues](https://github.com/symfinity/omnia-ipsum/issues) - Bug reports

