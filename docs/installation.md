# Installation

## Prerequisites

Add the [symfinity/recipes](https://github.com/symfinity/recipes) Flex endpoint to your project's `composer.json` (see [recipes README](https://github.com/symfinity/recipes/blob/main/README.md)).

## Composer

```bash
composer require symfinity/omnia-ipsum
```

## Symfony Flex

The recipe applies:

- `config/packages/symfinity_omnia_ipsum.yaml` from the package default
- Bundle registration for **`dev`** and **`test`** environments only

## Production

**Do not enable this bundle in production.**

Omnia Ipsum is for prototyping: external placeholder URLs, Faker output, and dummy media are not suitable for live sites.

- The Flex recipe does **not** register the bundle for `prod`.
- Do not add `Symfinity\OmniaIpsum\OmniaIpsumBundle` to `prod` in `config/bundles.php`.
- If the bundle was enabled manually, remove it from the `prod` environment before deploy.

For production content, use real assets and data sources instead of placeholder providers.

## Manual installation

When Flex is unavailable:

1. `composer require symfinity/omnia-ipsum`
2. Register `Symfinity\OmniaIpsum\OmniaIpsumBundle` for **`dev`** and **`test`** only in `config/bundles.php`
3. Copy `config/packages/symfinity_omnia_ipsum.yaml` from the package into your project

## Verify installation

```bash
php bin/console debug:config omnia_ipsum
```

## Next steps

[Quick start](quickstart.md).
