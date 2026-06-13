# Migration from neuralglitch/omnia-ipsum

Use this table when replacing the legacy Packagist package with `symfinity/omnia-ipsum` in a Symfony app.

## Package identity

| Item | Legacy (`neuralglitch/*`) | Symfinity (`symfinity/*`) |
|------|---------------------------|---------------------------|
| Composer name | `neuralglitch/omnia-ipsum` | `symfinity/omnia-ipsum` |
| PSR-4 namespace | `NeuralGlitch\OmniaIpsum\` | `Symfinity\OmniaIpsum\` |
| Test namespace | `NeuralGlitch\OmniaIpsum\Tests\` | `Symfinity\OmniaIpsum\Tests\` |
| Bundle class | `NeuralGlitch\OmniaIpsum\OmniaIpsumBundle` | `Symfinity\OmniaIpsum\OmniaIpsumBundle` |
| Config root key | `omnia_ipsum:` | `omnia_ipsum:` (unchanged) |
| Config file | `config/packages/omnia_ipsum.yaml` | `config/packages/omnia_ipsum.yaml` |

## Composer and Symfony floor

| Constraint | Legacy | Symfinity port |
|------------|--------|----------------|
| PHP | `>=8.1` | `>=8.1` (CI tests 8.2+) |
| Symfony components | `^6.4 \|\| ^7.0 \|\| ^8.0` | `^6.4 \|\| ^7.0 \|\| ^8.0` |

## Application changes

1. **Require** the new package and remove the old one:

   ```bash
   composer remove neuralglitch/omnia-ipsum
   composer require symfinity/omnia-ipsum
   ```

2. **Update imports** in PHP and tests: `NeuralGlitch\OmniaIpsum` → `Symfinity\OmniaIpsum`.

3. **Update `config/bundles.php`** if the class is registered manually:

   ```php
   // Before
   NeuralGlitch\OmniaIpsum\OmniaIpsumBundle::class => ['dev' => true, 'test' => true],

   // After
   Symfinity\OmniaIpsum\OmniaIpsumBundle::class => ['dev' => true, 'test' => true],
   ```

   Flex recipe for `symfinity/omnia-ipsum` registers the bundle for **dev** and **test** only.

4. **Twig templates** — function names are unchanged (`omnia_image`, `lorem_paragraphs`, `fake`, etc.).

5. **Production** — keep the bundle disabled in `prod` (see [README](../README.md#3-disable-in-production)).

## Abandon timeline

Do not abandon `neuralglitch/omnia-ipsum` on Packagist until `symfinity/omnia-ipsum` is installable and documented (wave-1 program gate G5 / intake M4).
