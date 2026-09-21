---
paths:
  - 'database/migrations/**'
---

# Migrations

## Forward-only migrations
Implement `up()` and omit `down()`. Migrations in this application are forward-only.

## Foreign keys
Use `foreignIdFor(Model::class)->constrained()` to enforce referential integrity. Do not cascade or null deletes in migrations. Delete related records in actions, composing child delete actions from the parent delete action. References that intentionally do not enforce referential integrity may remain unconstrained and indexed.

## Enum columns
Prefer string-backed PHP enums for persisted domain values and store their backing values in string columns. If an integer-backed enum is required, use an integer column. Cast enum columns to their enum classes in the model instead of using database enum columns.
