---
paths:
  - 'app/Actions/**'
---

# Actions

## Action structure
Business logic lives in reusable, composable Action classes under `app/Actions`. Name actions for what they do without an `Action` suffix. Actions are `final readonly` classes with one public `handle()` method.

Inject dependencies through constructor property promotion. Omit the constructor when an action has no dependencies. Mark password and secret string parameters with `#[SensitiveParameter]`.

Create actions with `php artisan make:action "{name}" --no-interaction`.

## Composition and transactions
Keep each action focused on one responsibility. A top-level action may compose sub-actions, but each sub-action must do one thing.

Wrap complex operations involving multiple models in `DB::transaction()`. When a top-level action orchestrates multiple sub-actions, wrap the entire orchestration in one transaction.

Actions may be called from controllers, jobs, commands, other actions, and other application entry points.
