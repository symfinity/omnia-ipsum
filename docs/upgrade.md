# Upgrade and migration

## 0.1.3

**Configuration rename:** Symfony config root key `omnia_ipsum:` → `symfinity_omnia_ipsum:`; default file `config/packages/symfinity_omnia_ipsum.yaml`.

1. Rename your config file (or let Flex overwrite on `composer update` if you have no local edits).
2. Replace the root key in YAML:

```yaml
# Before (0.1.2)
omnia_ipsum:
    images:
        default_provider: 'picsum'

# After (0.1.3)
symfinity_omnia_ipsum:
    images:
        default_provider: 'picsum'
```

Twig function names are unchanged.

```bash
composer update symfinity/omnia-ipsum
```

## 0.1.2

No breaking changes. Patch release: expanded split-mirror CI matrix and handbook cleanup only.

```bash
composer update symfinity/omnia-ipsum
```

## 0.1.1 (Symfinity relocation)

**Package rename:** `neuralglitch/omnia-ipsum` → `symfinity/omnia-ipsum`

**Namespace:** `NeuralGlitch\OmniaIpsum\` → `Symfinity\OmniaIpsum\`

### Migration steps

1. Remove the old package and require the successor:

```bash
composer remove neuralglitch/omnia-ipsum
composer require symfinity/omnia-ipsum:^0.1
```

2. Update Flex endpoint if needed — see [Installation](installation.md).
3. Replace namespace imports in PHP and tests:

```php
// Before
use NeuralGlitch\OmniaIpsum\OmniaIpsumBundle;

// After
use Symfinity\OmniaIpsum\OmniaIpsumBundle;
```

4. Update `config/bundles.php` if the bundle class is registered manually (Flex registers **dev** and **test** only).
5. Rename config root key `omnia_ipsum:` → `symfinity_omnia_ipsum:` and file to `symfinity_omnia_ipsum.yaml` when upgrading from 0.1.2 (see [upgrade.md](upgrade.md#013)).

See [Migration from neuralglitch](migration.md) for the full identity table.

## 0.1.0

Initial public release under `symfinity/omnia-ipsum` — Twig placeholder functions, image/video/audio providers, Lorem Ipsum, and Faker integration. See [Quickstart](quickstart.md).

## See also

- [Migration from neuralglitch](migration.md)
- [Configuration](configuration.md)
- [CHANGELOG](../CHANGELOG.md)
