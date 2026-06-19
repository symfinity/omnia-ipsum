# Text Generation

Generate Lorem Ipsum and realistic fake text for rapid prototyping.

## Overview

Omnia Ipsum includes two types of text generators:

1. **Lorem Ipsum** - Traditional placeholder text (gibberish)
2. **Faker RealText** - Realistic-looking English text (via `fake_text()`)

### Lorem Ipsum Functions

- Paragraphs
- Sentences
- Words
- Titles

All text uses traditional Lorem Ipsum vocabulary.

### Faker RealText

- `fake_text(maxChars)` - Generate realistic-looking text using Faker's realText() method
- Perfect for more believable prototypes and client demos

## Functions Reference

### `lorem_paragraphs(count)`

Generate multiple paragraphs of Lorem Ipsum text.

```twig
{# 3 paragraphs (default) #}
{{ lorem_paragraphs() }}

{# Custom count #}
{{ lorem_paragraphs(5) }}
{{ lorem_paragraphs(10) }}
```

**Parameters:**
- `count` (int): Number of paragraphs to generate (default: 3)

**Returns:** String with paragraphs separated by `\n\n`

### `lorem_paragraph()`

Generate a single paragraph.

```twig
<p>{{ lorem_paragraph() }}</p>
```

**Returns:** String containing 3-7 sentences

### `lorem_sentences(count)`

Generate multiple sentences.

```twig
{# 5 sentences (default) #}
{{ lorem_sentences() }}

{# Custom count #}
{{ lorem_sentences(10) }}
```

**Parameters:**
- `count` (int): Number of sentences to generate (default: 5)

**Returns:** String with sentences separated by spaces

### `lorem_sentence()`

Generate a single sentence.

```twig
<p class="intro">{{ lorem_sentence() }}</p>
```

**Returns:** String containing 4-16 words, ending with period

### `lorem_words(count)`

Generate Lorem Ipsum words.

```twig
{# 50 words (default) #}
{{ lorem_words() }}

{# Custom count #}
{{ lorem_words(100) }}
{{ lorem_words(20) }}
```

**Parameters:**
- `count` (int): Number of words to generate (default: 50)

**Returns:** String of lowercase words separated by spaces

### `lorem_title()`

Generate a title (3-6 capitalized words).

```twig
<h1>{{ lorem_title() }}</h1>
<h2>{{ lorem_title() }}</h2>
```

**Returns:** String with 3-6 words, each capitalized

## Usage Examples

### Blog Layout

```twig
<article>
    <h1>{{ lorem_title() }}</h1>
    <p class="lead">{{ lorem_sentence() }}</p>
    
    {{ lorem_paragraphs(5) }}
    
    <h2>{{ lorem_title() }}</h2>
    {{ lorem_paragraphs(3) }}
</article>
```

### Card Grid

```twig
<div class="cards">
    {% for i in 1..6 %}
        <div class="card">
            <h3>{{ lorem_title() }}</h3>
            <p>{{ lorem_sentences(2) }}</p>
            <a href="#">{{ lorem_words(2) }}</a>
        </div>
    {% endfor %}
</div>
```

### Long-Form Content

```twig
<div class="long-content">
    <h1>{{ lorem_title() }}</h1>
    
    {% for i in 1..10 %}
        {% if i % 3 == 0 %}
            <h2>{{ lorem_title() }}</h2>
        {% endif %}
        
        <p>{{ lorem_paragraph() }}</p>
    {% endfor %}
</div>
```

### Sidebar

```twig
<aside>
    <h3>{{ lorem_title() }}</h3>
    <p>{{ lorem_sentence() }}</p>
    
    <ul>
        {% for i in 1..5 %}
            <li>{{ lorem_words(3) }}</li>
        {% endfor %}
    </ul>
</aside>
```

## Text Formatting

### Paragraph Tags

```twig
{# Option 1: Split and wrap #}
{% set paragraphs = lorem_paragraphs(3)|split('\n\n') %}
{% for p in paragraphs %}
    <p>{{ p }}</p>
{% endfor %}

{# Option 2: Use nl2br filter #}
{{ lorem_paragraphs(3)|nl2br }}
```

### List Items

```twig
<ul>
    {% for i in 1..5 %}
        <li>{{ lorem_sentence() }}</li>
    {% endfor %}
</ul>
```

### Definition List

```twig
<dl>
    {% for i in 1..5 %}
        <dt>{{ lorem_title() }}</dt>
        <dd>{{ lorem_sentence() }}</dd>
    {% endfor %}
</dl>
```

### Blockquote

```twig
<blockquote>
    <p>{{ lorem_sentences(3) }}</p>
    <footer>
        <cite>{{ fake('name') }}</cite>
    </footer>
</blockquote>
```

## Text Manipulation

### Truncation

```twig
{# Truncate to 100 characters #}
{{ lorem_paragraph()|slice(0, 100) ~ '...' }}

{# Truncate to 20 words #}
{{ lorem_words(50)|split(' ')|slice(0, 20)|join(' ') ~ '...' }}
```

### Case Conversion

```twig
{# Uppercase title #}
<h1>{{ lorem_title()|upper }}</h1>

{# Lowercase #}
{{ lorem_title()|lower }}

{# First letter uppercase #}
{{ lorem_sentence()|capitalize }}
```

### Custom Separators

```twig
{# Comma-separated words #}
{{ lorem_words(10)|replace({' ': ', '}) }}

{# Dash-separated #}
{{ lorem_words(5)|replace({' ': ' - '}) }}
```

## Common Patterns

### Hero Section

```twig
<section class="hero">
    <h1>{{ lorem_title() }}</h1>
    <p class="lead">{{ lorem_sentence() }}</p>
    <button>{{ lorem_words(2) }}</button>
</section>
```

### Feature List

```twig
<div class="features">
    {% for i in 1..6 %}
        <div class="feature">
            <h3>{{ lorem_title() }}</h3>
            <p>{{ lorem_sentence() }}</p>
        </div>
    {% endfor %}
</div>
```

### Tabs Content

```twig
<div class="tabs">
    {% for i in 1..3 %}
        <div class="tab-pane">
            <h3>{{ lorem_title() }}</h3>
            {{ lorem_paragraphs(2) }}
        </div>
    {% endfor %}
</div>
```

### Accordion

```twig
<div class="accordion">
    {% for i in 1..5 %}
        <div class="accordion-item">
            <h4>{{ lorem_title() }}</h4>
            <div class="accordion-content">
                {{ lorem_paragraph() }}
            </div>
        </div>
    {% endfor %}
</div>
```

## Configuration

```yaml
# config/packages/symfinity_omnia_ipsum.yaml
symfinity_omnia_ipsum:
    text:
        default_paragraphs: 5   # Default paragraph count
        default_sentences: 10   # Default sentence count
        default_words: 100      # Default word count
```

## Best Practices

### Match Real Content

```twig
{# ✅ Good: Appropriate lengths #}
<h1>{{ lorem_title() }}</h1>         {# 3-6 words #}
<p class="intro">{{ lorem_sentence() }}</p>  {# 1 sentence #}
<article>{{ lorem_paragraphs(5) }}</article>  {# Multiple paragraphs #}

{# ❌ Avoid: Unrealistic lengths #}
<h1>{{ lorem_paragraphs(10) }}</h1>  {# Too long for heading #}
<button>{{ lorem_sentence() }}</button>  {# Too long for button #}
```

### Use Appropriate Functions

```twig
{# ✅ Good: Function matches use case #}
<h1>{{ lorem_title() }}</h1>          {# Title function for headings #}
<p>{{ lorem_paragraph() }}</p>        {# Paragraph function for content #}
<span>{{ lorem_words(3) }}</span>     {# Words for short text #}

{# ❌ Avoid: Wrong function for use case #}
<h1>{{ lorem_sentence() }}</h1>       {# Sentence ends with period! #}
<button>{{ lorem_paragraph() }}</button>  {# Too long! #}
```

### Combining with Images

```twig
{# ✅ Good: Text matches image #}
<div class="media">
    <img src="{{ omnia_image(400, 300, {provider: 'picsum'}) }}">
    <h3>{{ lorem_title() }}</h3>
    <p>{{ lorem_sentence() }}</p>
</div>
```

## Realistic Fake Text (Alternative to Lorem Ipsum)

### `fake_text(maxChars)`

Generate realistic-looking English text using Faker's `realText()` method. Perfect for more believable prototypes!

```twig
{# Short text (200 chars default) #}
<p>{{ fake_text() }}</p>

{# Custom length #}
<p>{{ fake_text(400) }}</p>
<div class="article">{{ fake_text(800) }}</div>
```

**Parameters:**
- `maxChars` (int): Maximum characters (default: 200)

**Returns:** Realistic-looking English text

### Lorem Ipsum vs Faker Text

| Feature | Lorem Ipsum | Faker Text |
|---------|-------------|------------|
| **Appearance** | Latin gibberish | Real English |
| **Use Case** | Layout testing | Client demos |
| **Performance** | Very fast | Slightly slower |
| **Best For** | Wireframes | Realistic prototypes |

### Example: Blog with Realistic Text

```twig
<article>
    <h1>{{ lorem_title() }}</h1>
    <p class="lead">{{ fake_text(150) }}</p>
    
    <p>{{ fake_text(400) }}</p>
    <p>{{ fake_text(350) }}</p>
</article>
```

## See Also

- [Quick Reference](quickstart.md) - Get started quickly
- [Faker Integration](faker.md) - Realistic fake data (names, emails, etc.)
- [Configuration](configuration.md) - Customize text defaults
