# Video Providers

Complete reference for placeholder video generation.

## Google Cloud Storage Provider (Default)

**Provider:** `gcs` (Google Cloud Storage)  
**Source:** [https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/](https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/)

The Google Cloud Storage provider offers 13 professional, high-quality videos from Google's public video bucket. All videos are **directly playable**, **fast**, **reliable**, and **free** to use.

### Available Videos

| Video Name | Description | Type |
|------------|-------------|------|
| `big-buck-bunny` | Animated comedy short by Blender Foundation | Animation |
| `sintel` | Fantasy adventure short by Blender Foundation | Animation |
| `elephants-dream` | Surreal sci-fi short by Blender Foundation | Animation |
| `tears-of-steel` | Live-action sci-fi short by Blender Foundation | Live Action |
| `for-bigger-blazes` | Google demo video | Commercial |
| `for-bigger-escapes` | Google demo video | Commercial |
| `for-bigger-fun` | Google demo video | Commercial |
| `for-bigger-joyrides` | Google demo video | Commercial |
| `for-bigger-meltdowns` | Google demo video | Commercial |
| `subaru-outback` | Subaru car commercial | Commercial |
| `vw-gti-review` | Volkswagen GTI review | Review |
| `we-are-going-on-bullrun` | Adventure video | Adventure |
| `what-car-can-you-get` | Car shopping guide | Guide |

### Basic Usage

```twig
{# Default video (Big Buck Bunny) #}
<video src="{{ omnia_video(1920, 1080) }}" controls></video>

{# Specific video #}
<video src="{{ omnia_video(1920, 1080, {video: 'sintel'}) }}" controls></video>
```

### All Videos Examples

```twig
{# Animation Videos #}
<video src="{{ omnia_video(1920, 1080, {video: 'big-buck-bunny'}) }}" controls></video>
<video src="{{ omnia_video(1920, 1080, {video: 'sintel'}) }}" controls></video>
<video src="{{ omnia_video(1920, 1080, {video: 'elephants-dream'}) }}" controls></video>
<video src="{{ omnia_video(1920, 1080, {video: 'tears-of-steel'}) }}" controls></video>

{# Google Demo Videos #}
<video src="{{ omnia_video(1920, 1080, {video: 'for-bigger-blazes'}) }}" controls></video>
<video src="{{ omnia_video(1920, 1080, {video: 'for-bigger-escapes'}) }}" controls></video>
<video src="{{ omnia_video(1920, 1080, {video: 'for-bigger-fun'}) }}" controls></video>
<video src="{{ omnia_video(1920, 1080, {video: 'for-bigger-joyrides'}) }}" controls></video>
<video src="{{ omnia_video(1920, 1080, {video: 'for-bigger-meltdowns'}) }}" controls></video>

{# Car Videos #}
<video src="{{ omnia_video(1920, 1080, {video: 'subaru-outback'}) }}" controls></video>
<video src="{{ omnia_video(1920, 1080, {video: 'vw-gti-review'}) }}" controls></video>

{# Other Videos #}
<video src="{{ omnia_video(1920, 1080, {video: 'we-are-going-on-bullrun'}) }}" controls></video>
<video src="{{ omnia_video(1920, 1080, {video: 'what-car-can-you-get'}) }}" controls></video>
```

### Supported Options

| Option | Type | Default | Description |
|--------|------|---------|-------------|
| `video` | string | `'big-buck-bunny'` | Video name from available list |
| `provider` | string | `'gcs'` | Provider name (always 'gcs') |

### Complete Example

```twig
<div class="video-gallery">
    {# Hero Video with Big Buck Bunny #}
    <video 
        src="{{ omnia_video(1920, 1080) }}" 
        controls 
        autoplay 
        muted 
        loop
        class="hero-video"
    ></video>

    {# Feature Videos #}
    <div class="row">
        {% set videos = ['sintel', 'elephants-dream', 'tears-of-steel'] %}
        {% for video in videos %}
            <div class="col-md-4">
                <video 
                    src="{{ omnia_video(1920, 1080, {video: video}) }}" 
                    controls
                    preload="metadata"
                    class="feature-video"
                ></video>
            </div>
        {% endfor %}
    </div>

    {# Product Demo Videos #}
    {% for video in ['for-bigger-fun', 'for-bigger-joyrides', 'for-bigger-meltdowns'] %}
        <video 
            src="{{ omnia_video(1920, 1080, {video: video}) }}" 
            controls
            class="product-video"
        ></video>
    {% endfor %}
</div>
```

## Video Details

### Big Buck Bunny (Default)
- **Type:** Animation
- **Genre:** Comedy
- **Source:** Blender Foundation
- **Description:** Open-source animated comedy short featuring a large rabbit

### Sintel
- **Type:** Animation
- **Genre:** Fantasy/Adventure
- **Source:** Blender Foundation
- **Description:** CGI fantasy short film about a lonely girl searching for her dragon

### Elephants Dream
- **Type:** Animation
- **Genre:** Sci-Fi/Surreal
- **Source:** Blender Foundation
- **Description:** First open movie project by Blender Foundation

### Tears of Steel
- **Type:** Live Action
- **Genre:** Sci-Fi
- **Source:** Blender Foundation
- **Description:** Science fiction short film combining live action and CGI

## Advantages

### ✅ Why Google Cloud Storage?

1. **Reliability** - Google's CDN infrastructure
2. **Speed** - Fast global delivery
3. **Free** - Public bucket, no API keys needed
4. **Quality** - Professional videos
5. **Variety** - 13 different videos (animation, commercial, live action)
6. **Direct Playback** - Real MP4 files, not generators
7. **No Rate Limits** - Unlimited access

### ❌ What's NOT Supported?

- Custom video generation
- Dynamic text/watermarks
- Custom durations
- Different resolutions (videos are as-is)

## Use Cases

### ✅ Best for:

- **Video Player Testing** - Test video controls, autoplay, etc.
- **Layout Testing** - Test responsive video designs
- **Prototyping** - Quick demos with real videos
- **CI/CD Testing** - Reliable videos for automated tests
- **Demos & Presentations** - Professional-looking videos
- **Documentation** - Consistent example videos

### ⚠️ Not Ideal for:

- Testing specific video sizes (all videos are high resolution)
- Testing custom video metadata
- Testing video generation workflows

## Configuration

### Set Default Video

```yaml
# config/packages/omnia_ipsum.yaml
omnia_ipsum:
    videos:
        default_provider: 'gcs'  # Default
        default_width: 1920
        default_height: 1080
```

### Use in Templates

```twig
{# Uses default provider (gcs) #}
<video src="{{ omnia_video(1920, 1080) }}" controls></video>

{# Explicit provider (same as default) #}
<video src="{{ omnia_video(1920, 1080, {provider: 'gcs'}) }}" controls></video>
```

## Programmatic Access

### Get Available Videos

```php
use Symfinity\OmniaIpsum\Provider\GoogleCloudStorageVideoProvider;

// Get all available video names
$videos = GoogleCloudStorageVideoProvider::getAvailableVideos();
// Returns: ['big-buck-bunny', 'sintel', 'elephants-dream', ...]
```

### Generate URLs

```php
use Symfinity\OmniaIpsum\Service\VideoProviderManager;

$manager = $container->get(VideoProviderManager::class);

// Default video
$url = $manager->generate(1920, 1080);

// Specific video
$url = $manager->generate(1920, 1080, ['video' => 'sintel']);
```

## Performance

### Video Sizes

All videos are high quality and relatively large:
- **Big Buck Bunny:** ~158 MB
- **Sintel:** ~148 MB
- Other videos: ~10-50 MB

### Recommendations

1. **Use `preload="metadata"`** for better performance
2. **Use poster images** for video thumbnails
3. **Consider lazy loading** for multiple videos
4. **Use autoplay sparingly** (especially on mobile)

### Example with Optimization

```twig
<video 
    src="{{ omnia_video(1920, 1080, {video: 'sintel'}) }}"
    poster="{{ omnia_image(1920, 1080, {provider: 'picsum'}) }}"
    preload="metadata"
    controls
    class="optimized-video"
></video>
```

## See Also

- [Configuration](configuration.md) - Configure default video settings
- [Image Providers](images.md) - Generate poster images for videos
- [Google Sample Videos](https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/) - Official source
