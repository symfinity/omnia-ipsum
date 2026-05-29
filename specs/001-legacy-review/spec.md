# Legacy review — symfinity/omnia-ipsum

**Status**: Executed (M3, post-port QA green)  
**Created**: 2026-05-25

## Purpose

Understand the migrated package before feature specs or refactors. Gate for wave-1 B3 / intake milestone M3.

## Scope

- Architecture and module boundaries
- Dependencies (Composer, Symfony, internal)
- Release slice vs intake (`r1_must` / `defer` / `drop`)
- Legacy risks and technical debt
- Test coverage gaps
- Modernization opportunities (candidates only)
- Safe vs dangerous refactor areas

## Anti-patterns

- No blind rewrites
- No speculative abstractions
- No uncontrolled modernization
- No removing legacy code without relevance analysis

## Deliverables (Phase 4)

1. Architecture overview — [report.md](./report.md#1-architecture-overview)
2. Relevance/risk matrix (min 8 rows) — [report.md](./report.md#2-relevancerisk-matrix)
3. Modernization candidates — [report.md](./report.md#3-modernization-candidates)
4. Refactor assessment — [report.md](./report.md#4-refactor-assessment)
5. Dependency bottlenecks — [report.md](./report.md#5-dependency-bottlenecks)

## M3 checklist (intake release slice)

| Item | Tier | Result |
|------|------|--------|
| Core bundle + DI + Twig runtime | r1_must | Pass |
| Twig functions (`omnia_*`, `lorem_*`, `fake_*`) | r1_must | Pass |
| Flex recipe `recipes/symfinity/omnia-ipsum/0.1/` | r1_must | Pass (dev/test bundle env fixed in M3) |
| Consumer migration table | r1_must | Pass — [docs/migration.md](../../docs/migration.md) |
| GCP video provider deep docs | defer | Deferred — `docs/videos.md` retained |
| Infection in default CI | defer | Deferred — no package `.github/` in monorepo |
| Packagist / abandon | M4 | Out of scope |

## Boundary

- No `specs/002+` until maintainer approves Phase 4 report
- No git branch or commit from this review workflow unless user requests
