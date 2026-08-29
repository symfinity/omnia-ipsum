# Verification

**Integration profile:** P0 — dev/test helpers (Twig functions).

## Local commands

```bash
composer test
composer phpstan
```

## Clean-app smoke

On a fresh Symfony 7.4+ project (`APP_ENV=dev`):

```bash
composer require --dev symfinity/omnia-ipsum
php bin/console debug:config symfinity_omnia_ipsum
```

In a Twig template, render `{{ omnia_image(400, 300) }}` — expect HTTP 200 and a placeholder `<img>` in the response.

## See also

- [Quickstart](quickstart.md)
- [CHANGELOG](../CHANGELOG.md)
