# Audio Providers

Complete reference for placeholder audio generation.

## Silence Provider

The Silence provider generates silent audio files as data URLs (base64-encoded WAV files).

### Basic Usage

```twig
{# Generate 10 seconds of silence #}
<audio src="{{ omnia_audio(10) }}" controls></audio>

{# Generate 30 seconds of silence #}
<audio src="{{ omnia_audio(30) }}" controls></audio>
```

### Custom Sample Rate

```twig
{# 48kHz (professional quality) #}
<audio src="{{ omnia_audio(10, {
    sample_rate: 48000
}) }}" controls></audio>

{# 44.1kHz (CD quality, default) #}
<audio src="{{ omnia_audio(10, {
    sample_rate: 44100
}) }}" controls></audio>

{# 22.05kHz (low quality) #}
<audio src="{{ omnia_audio(10, {
    sample_rate: 22050
}) }}" controls></audio>
```

### Mono vs Stereo

```twig
{# Mono (1 channel) #}
<audio src="{{ omnia_audio(10, {
    channels: 1
}) }}" controls></audio>

{# Stereo (2 channels, default) #}
<audio src="{{ omnia_audio(10, {
    channels: 2
}) }}" controls></audio>
```

### Supported Options

| Option | Type | Default | Description |
|--------|------|---------|-------------|
| `sample_rate` | int | 44100 | Sample rate in Hz (22050, 44100, 48000) |
| `channels` | int | 2 | Number of channels (1=mono, 2=stereo) |

## Technical Specifications

### WAV Format

The Silence provider generates valid WAV files:

- **Format**: PCM (Pulse Code Modulation)
- **Bit Depth**: 16-bit
- **Encoding**: Linear PCM
- **Container**: WAV (RIFF)
- **Compression**: None (uncompressed)
- **Data URL**: Base64-encoded

### File Size Calculation

File size depends on:
- Duration (seconds)
- Sample rate (Hz)
- Channels (mono/stereo)

**Formula:**
```
Size (bytes) = duration × sample_rate × channels × 2 + 44
Size (base64) = Size (bytes) × 1.37 (approx)
```

**Examples:**

| Duration | Sample Rate | Channels | File Size | Base64 Size |
|----------|-------------|----------|-----------|-------------|
| 1s | 44100 Hz | Mono | ~88 KB | ~121 KB |
| 1s | 44100 Hz | Stereo | ~176 KB | ~241 KB |
| 10s | 44100 Hz | Stereo | ~1.7 MB | ~2.3 MB |
| 30s | 44100 Hz | Stereo | ~5.2 MB | ~7.1 MB |
| 60s | 44100 Hz | Stereo | ~10.3 MB | ~14.1 MB |

### Duration Limits

The provider limits duration to prevent memory issues:

- **Minimum**: 1 second
- **Maximum**: 60 seconds

Longer durations are automatically clamped to 60 seconds.

```twig
{# This will generate 60s, not 120s #}
{{ omnia_audio(120) }}
```

## Use Cases

### Audio Player Testing

```twig
<div class="audio-player">
    <audio src="{{ omnia_audio(30) }}" controls></audio>
    <div class="controls">
        <button class="play">Play</button>
        <button class="pause">Pause</button>
        <input type="range" class="volume" min="0" max="100" value="50">
    </div>
</div>
```

### Podcast Player

```twig
<div class="podcast">
    {% for i in 1..5 %}
        <div class="episode">
            <img src="{{ omnia_avatar(fake('name'), 100) }}" alt="Host">
            <h3>{{ lorem_title() }}</h3>
            <p>{{ fake('name') }} - {{ fake('dateTime')|date('F j, Y') }}</p>
            <audio src="{{ omnia_audio(45) }}" controls></audio>
            <p>{{ lorem_sentence() }}</p>
        </div>
    {% endfor %}
</div>
```

### Music Player

```twig
<div class="music-player">
    <div class="playlist">
        {% for i in 1..10 %}
            <div class="track">
                <span class="track-number">{{ i }}</span>
                <span class="track-title">{{ lorem_title() }}</span>
                <span class="track-artist">{{ fake('name') }}</span>
                <audio src="{{ omnia_audio(180) }}" data-track="{{ i }}"></audio>
            </div>
        {% endfor %}
    </div>
</div>
```

### Audio Recorder Interface

```twig
<div class="recorder">
    <button class="record">🔴 Record</button>
    <button class="stop">⏹ Stop</button>
    
    <div class="recordings">
        {% for i in 1..5 %}
            <div class="recording">
                <span>Recording {{ i }}</span>
                <audio src="{{ omnia_audio(fake('numberBetween', [5, 30])) }}" controls></audio>
                <button class="delete">Delete</button>
            </div>
        {% endfor %}
    </div>
</div>
```

## Performance Considerations

### Data URL Size

Data URLs are embedded directly in HTML:

```html
<!-- This embeds ~2.3MB of base64 data in your HTML! -->
<audio src="data:audio/wav;base64,UklGR...very long base64..."></audio>
```

**Impact:**
- Increases HTML page size
- Slower initial page load
- No browser caching
- No CDN benefits

**Recommendations:**

✅ **Use for:**
- Quick prototypes
- Testing audio players
- Short durations (1-10s)
- Development only

❌ **Avoid for:**
- Production sites
- Long durations (>30s)
- Multiple audio files
- Mobile devices

### Alternative for Production

For production prototypes, consider:

1. **Use real audio files** (smaller file size)
2. **Use external services** (Soundcloud, etc.)
3. **Generate once, save as file** (instead of inline data URL)

## Browser Compatibility

### Data URLs

✅ **Supported:**
- Chrome/Edge
- Firefox
- Safari
- Opera

**Limitations:**
- Some browsers limit data URL size
- Mobile browsers may have stricter limits
- Older browsers may not support WAV

### Audio Element

The HTML5 `<audio>` element is supported in all modern browsers.

## Advanced Usage

### Programmatic Access

```php
use Symfinity\OmniaIpsum\Service\AudioProviderManager;

$audioManager = $container->get(AudioProviderManager::class);

// Generate audio data URL
$dataUrl = $audioManager->generate(10, [
    'sample_rate' => 48000,
    'channels' => 2,
]);

// Use in response
return new Response('<audio src="' . $dataUrl . '" controls></audio>');
```

### Custom Provider

Create your own audio provider:

```php
<?php

declare(strict_types=1);

namespace App\Provider;

use Symfinity\OmniaIpsum\Provider\AudioProviderInterface;

final class ToneGeneratorProvider implements AudioProviderInterface
{
    public function generate(int $duration, array $options = []): string
    {
        $frequency = $options['frequency'] ?? 440; // A4 note
        
        // Generate tone (simplified example)
        return 'data:audio/wav;base64,' . base64_encode($this->generateTone($duration, $frequency));
    }

    public function getName(): string
    {
        return 'tone';
    }

    public function supportsOption(string $option): bool
    {
        return $option === 'frequency';
    }
    
    private function generateTone(int $duration, int $frequency): string
    {
        // Implementation for tone generation
        // ...
    }
}
```

Register in services:

```yaml
services:
    App\Provider\ToneGeneratorProvider:
        tags:
            - { name: 'omnia_ipsum.audio_provider' }
```

## Troubleshooting

### Audio Not Playing

**Problem:**
Audio element doesn't play.

**Solution:**
1. Check browser console for errors
2. Verify data URL is complete
3. Try shorter duration
4. Check browser compatibility

### Audio Too Large

**Problem:**
Page loads very slowly or crashes.

**Solution:**
1. Reduce duration:
   ```twig
   {# ❌ Too long #}
   {{ omnia_audio(300) }}  {# 5 minutes! #}
   
   {# ✅ Reasonable #}
   {{ omnia_audio(10) }}
   ```

2. Reduce sample rate:
   ```twig
   {# ✅ Smaller file #}
   {{ omnia_audio(30, {sample_rate: 22050}) }}
   ```

3. Use mono instead of stereo:
   ```twig
   {# ✅ Half the size #}
   {{ omnia_audio(30, {channels: 1}) }}
   ```

### Memory Issues

**Problem:**
```
Allowed memory size exhausted
```

**Solution:**
The provider limits duration to 60 seconds to prevent this. If you still hit memory limits:

1. Reduce duration further (max 30s)
2. Use lower sample rate (22050 Hz)
3. Use mono (1 channel)
4. Increase PHP memory limit (temporary):
   ```ini
   memory_limit = 512M
   ```

## See Also

- [Usage Guide](usage.md) - How to use audio in templates
- [Configuration](configuration.md) - Set default audio settings
- [Video Providers](videos.md) - Placeholder videos

