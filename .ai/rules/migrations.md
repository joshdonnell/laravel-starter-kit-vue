---
paths:
  - 'database/migrations/**'
---

# Migrations

## Forward-only migrations
Implement `up()` and omit `down()`. Migrations in this application are forward-only.

## Foreign keys
For owned model relationships that should be removed with their parent, use `foreignIdFor(Model::class)->constrained()->cascadeOnDelete()`. For other constrained relationships, choose the delete behavior explicitly. References that intentionally do not enforce referential integrity may remain unconstrained and indexed.

## Enum columns
Prefer string-backed PHP enums for persisted domain values and store their backing values in string columns. If an integer-backed enum is required, use an integer column. Cast enum columns to their enum classes in the model instead of using database enum columns.
