# Legacy Review Report — symfinity/omnia-ipsum

**Date**: 2026-05-25  
**Source**: `_archive/import-packages/omnia-ipsum` (neuralglitch)  
**Migrated**: `packages/omnia-ipsum/`  
**QA**: 164 PHPUnit tests, consumer `make test` green (symfinity/omnia-ipsum + demo-kit)

## 1. Architecture overview

| Area | Summary |
|------|---------|
| **Role** | Symfony bundle — Twig placeholder helpers (images, video, audio, Lorem, Faker) for dev/prototype |
| **Entry** | `OmniaIpsumBundle` → `OmniaIpsumExtension` loads `config/services.yaml` + `omnia_ipsum` config tree |
| **Twig** | `OmniaIpsumExtension` + lazy runtimes (`ImageRuntime`, `VideoRuntime`, `AudioRuntime`, `TextRuntime`, `FakerRuntime`) |
| **Services** | Provider managers (image/video/audio), `TextGenerator`, `FakerFactory`, console commands |
| **Integrations** | External HTTP image/video URLs; FakerPHP; no DB, Messenger, or AssetMapper |

**Major `src/` modules**

| Path | Purpose |
|------|---------|
| `DependencyInjection/` | Config tree, extension loader |
| `Provider/` | Image/video/audio URL builders per backend |
| `Service/` | Manager orchestration, text + faker |
| `Twig/` | Extension + runtimes |
| `Command/` | `omnia:list-providers`, `omnia:test-providers`, `omnia:validate` |

## 2. Relevance/risk matrix

| Area | Relevance | Risk | Notes |
|------|-----------|------|-------|
| Config `omnia_ipsum.yaml` | High | Safe | Same key as legacy; recipe copies defaults |
| Twig public API | High | Safe | Function names stable; no BC break intended |
| Image providers (HTTP) | High | Caution | Third-party uptime; tests mock where possible |
| GCS video provider | Medium | Caution | Network + Google-hosted assets; docs deferred not removed |
| Console commands | Medium | Safe | Dev tooling only |
| PHPUnit suite | High | Safe | Broad coverage; monorepo runs via `mono qa:test` |
| README / badges | Medium | Safe | M3 aligned versions; removed stale Packagist badges |
| Flex recipe env | High | Safe | M3: `dev`+`test` only (was `all`) |
| Split CI workflows | Low | Safe | Not ported; defer Infection to later |
| Namespace migration | High | Safe | Documented in `docs/migration.md` |
| Production enablement | High | Dangerous | Must stay dev/test-only |

## 3. Modernization candidates

| Candidate | Effort | Dependency |
|-----------|--------|------------|
| Add package-level PHPStan config in monorepo QA profile | S | Blocked on symfinity root qa:phpstan wiring for all packages |
| Symfony 8.x explicit QA matrix | M | Org **048** before floor bump |
| Extract provider interfaces for third-party backends | L | Second consumer need |
| Recipe dogfood fixture app (M2) | M | symfinity **001** / consumer fixture |
| Split-repo CI publish | M | M4 Packagist + mirror |

## 4. Refactor assessment

**Safe zones**

- Doc-only updates (migration table, README floors)
- Recipe manifest env keys
- Type hints / PHPStan fixes without behavior change

**Dangerous zones**

- Changing Twig function signatures or default provider URLs (template BC)
- Removing GCS video provider without deprecation period
- Enabling bundle in `prod` by default

**Dead-code suspicions**

- None flagged; legacy offline providers already removed in upstream CHANGELOG.

## 5. Dependency bottlenecks

| Topic | State |
|-------|--------|
| PHP | `>=8.2` — matches symfinity consumer root |
| Symfony | `^7.4` — aligned with org import floor; no 6.4 in ported tree |
| Faker | `^1.23` — stable |
| Cross-package | No hard dep on `symfinity/google-fonts` or `font-manager` (intake overlap advisory only) |
| Monorepo discovery | Path repo `packages/*`; slug `omnia-ipsum` matches Composer name |

## M3 fixes applied

1. Added `docs/migration.md` (r1_must migration-guide-snippet).
2. Flex recipe: bundle environments `dev`, `test` only.
3. README: PHP 8.2+ / Symfony 7.4+; migration link; trimmed stale CI/Packagist badges.
4. This spec + report under `specs/001-legacy-review/`.

## Verdict

**No maintainer POLL required** — direct rename port; public API and config prefix unchanged. Proceed to M2 recipe dogfood when scheduled; M4 Packagist/abandon separately.
