# Console Commands

Omnia Ipsum provides console commands for managing and testing providers.

## Available Commands

### `omnia:list-providers`

List all available providers with their supported options.

```bash
php bin/console omnia:list-providers
```

**Output:**
- Image providers (5 providers)
- Video providers (1 provider)
- Audio providers (1 provider)
- Supported options for each provider

**Example:**
```
Omnia Ipsum - Available Providers

Image Providers
===============
Name          Supported Options
--------------------------------
picsum        seed
placeholder   text, background, foreground
dummyimage    text, format
placehold     text, background, foreground
ui-avatars    name, background, foreground, bold, rounded

Video Providers
===============
Name          Supported Options
--------------------------------
gcs           video

Audio Providers
===============
Name          Supported Options
--------------------------------
silence       sample_rate, channels
```

### `omnia:test-providers`

Test all providers for availability and health.

```bash
php bin/console omnia:test-providers
```

**Options:**
- `--type=TYPE` - Test specific type (images, videos, audios, all) - default: `all`
- `--timeout=SECONDS` - Timeout in seconds - default: `5`
- `--clear-cache` - Clear health check cache before testing

**Examples:**
```bash
# Test all providers
php bin/console omnia:test-providers

# Test only image providers
php bin/console omnia:test-providers --type=images

# Test with custom timeout
php bin/console omnia:test-providers --timeout=10

# Clear cache and test
php bin/console omnia:test-providers --clear-cache
```

**Output:**
```
Omnia Ipsum - Provider Health Check

Image Providers
===============
Provider      Status
-------------------
picsum        ✓ Healthy
placeholder   ✓ Healthy
dummyimage    ✓ Healthy
placehold     ✓ Healthy
ui-avatars    ✓ Healthy

✓ All 5 provider(s) are healthy.
```

### `omnia:validate`

Validate Omnia Ipsum configuration and test all providers.

```bash
php bin/console omnia:validate
```

**What it checks:**
- All providers are registered
- Providers can generate URLs
- Configuration is valid

**Output:**
```
Omnia Ipsum - Configuration Validation

Image Providers
===============
✓ 5 image provider(s) registered.

Video Providers
===============
✓ 1 video provider(s) registered.

Audio Providers
===============
✓ 1 audio provider(s) registered.

✓ Configuration is valid!
```

**Exit codes:**
- `0` - Configuration is valid
- `1` - Configuration has errors

## Use Cases

### CI/CD Integration

Add provider validation to your CI/CD pipeline:

```yaml
# .github/workflows/test.yml
- name: Validate Omnia Ipsum
  run: php bin/console omnia:validate
```

### Health Monitoring

Regularly check provider health:

```bash
# Cron job: Check providers daily
0 2 * * * cd /path/to/project && php bin/console omnia:test-providers --type=all
```

### Debugging

When providers fail, use commands to diagnose:

```bash
# List all providers
php bin/console omnia:list-providers

# Test specific provider type
php bin/console omnia:test-providers --type=images

# Clear cache and retest
php bin/console omnia:test-providers --clear-cache
```

## Health Check Caching

The `omnia:test-providers` command uses caching to avoid excessive network requests:

- **Cache TTL**: 5 minutes
- **Cache scope**: Per provider
- **Clear cache**: Use `--clear-cache` option

**Why caching?**
- Reduces network load
- Faster command execution
- Prevents rate limiting

**When to clear cache:**
- After provider configuration changes
- When debugging provider issues
- Before important tests

## Troubleshooting

### Provider Not Found

**Error:**
```
Image provider "invalid" not found.
```

**Solution:**
1. Check available providers: `php bin/console omnia:list-providers`
2. Verify provider name spelling
3. Check configuration: `php bin/console omnia:validate`

### Provider Unavailable

**Error:**
```
✗ Unavailable
```

**Solution:**
1. Check network connectivity
2. Verify provider URL is accessible
3. Try again later (temporary outage)
4. Use different provider as fallback

### Timeout Issues

**Error:**
```
Timeout after 5 seconds
```

**Solution:**
1. Increase timeout: `--timeout=10`
2. Check network speed
3. Verify provider is responding
4. Check firewall/proxy settings

## See Also

- [Configuration](configuration.md) - Configure default providers
- [Image Providers](images.md) - Image provider details
- [Video Providers](videos.md) - Video provider details
- [Audio Providers](audios.md) - Audio provider details
