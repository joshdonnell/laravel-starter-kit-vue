---
paths:
  - 'app/Actions/**'
---

# Actions

## Action structure
Business logic lives in reusable, composable Action classes under `app/Actions`. Name actions for what they do without an `Action` suffix. Actions are `final readonly` classes with one public `handle()` method.

Inject dependencies through constructor property promotion. Omit the constructor when an action has no dependencies. Mark password and secret string parameters with `#[SensitiveParameter]`.

Create actions with `php artisan make:action "{name}" --no-interaction`.

## Validated attributes
Pass already-validated request input as `array $attributes`. Do not unpack request fields into individual `handle()` arguments. Keep models and actors as typed parameters. Actions that take no request input omit `$attributes`.

Do not validate in actions. Validation lives in Form Requests. An action receives information that has already been validated.

Do not dispatch events or rely on listeners for application workflow. Compose other actions instead.

## Composition and transactions
Keep each action focused on one responsibility. A top-level action may compose sub-actions, but each sub-action must do one thing.

Wrap complex operations involving multiple models in `DB::transaction()`. When a top-level action orchestrates multiple sub-actions, wrap the entire orchestration in one transaction. Parent delete actions compose child delete actions instead of relying on database cascade deletes.

Actions may be called from controllers, jobs, commands, other actions, and other application entry points.
