---
paths:
  - 'app/Data/**'
  - 'app/Enums/**'
  - 'app/Http/Controllers/**'
  - 'app/Http/Middleware/HandleInertiaRequests.php'
  - 'app/Providers/TypeScriptTransformerServiceProvider.php'
  - 'resources/js/types/**'
  - 'resources/js/pages/**'
  - 'resources/js/components/**'
  - 'tests/**'
  - 'composer.json'
  - 'package.json'
  - 'vite.config.ts'
  - 'tsconfig.json'
  - '.github/workflows/**'
---

# Backend to frontend TypeScript

## Contract source
Use final Spatie Laravel Data classes under `app/Data` as the source of truth for structured values sent from PHP to Inertia. Declare explicit public readonly constructor properties. Convert Eloquent models into Data objects and send Data instances or collections instead of exposing models or maintaining matching object shapes in PHP and TypeScript.

Laravel Data classes are transformed automatically and do not need `#[TypeScript]`. Application enums under `app/Enums` are also transformed automatically. Other PHP classes must opt in with `#[TypeScript]`.

## TypeScript consumption
Consume generated ambient names such as `App.Data.UserData`. A local alias may improve component APIs, but it must reference the generated type rather than repeat its fields. Handwritten TypeScript types are only for frontend-owned state and component APIs.

Shared contracts belong in `InertiaConfig.sharedPageProps`. Keep guest values nullable, such as `App.Data.UserData | null`. Spatie does not infer the props inside an `Inertia::render()` response, so declare page props with `defineProps` and reference generated Data types for structured values. Mirror scalar keys exactly.

## Nullability and optionality
A nullable PHP property generates a required TypeScript property whose value includes `null`. Do not represent it with `?`. Use Laravel Data's `Optional` or lazy types only when the serialized key may be absent. Carbon values are generated as strings.

## Generation
Run `composer transform-types` after changing Data classes or enums. Vite runs this command while developing when files under `app/Data` or `app/Enums` change, and Composer runs it before the project's type checks.

Treat `resources/js/types/generated.d.ts` and `resources/js/types/typescript-transformer-manifest.json` as generated artifacts. Never edit or commit them. The writer filename must remain relative to `resources/js/types` so generation is independent of a developer's machine path.

## Verification
Test Data construction and serialized Inertia shapes. Run `composer transform-types`, `composer test:types`, and the affected Pest tests after changing a backend to frontend contract.
