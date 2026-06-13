# Upgrade and migration

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
5. Twig function names and `omnia_ipsum:` config keys are unchanged.

See [Migration from neuralglitch](migration.md) for the full identity table.

## 0.1.0

Initial public release under `symfinity/omnia-ipsum` — Twig placeholder functions, image/video/audio providers, Lorem Ipsum, and Faker integration. See [Quickstart](quickstart.md).

## See also

- [Migration from neuralglitch](migration.md)
- [Configuration](configuration.md)
- [CHANGELOG](../CHANGELOG.md)
