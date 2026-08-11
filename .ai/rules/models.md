---
paths:
  - 'app/Models/*.php'
  - 'app/Models/**'
---

# Models

## Mass assignment
Models are globally unguarded through Essentials. Do not add `$fillable` or `$guarded`. Pass validated or explicitly selected attributes to model writes.

## Dates
Treat application dates as immutable. Keep Essentials immutable dates enabled. Use `now()` or `today()` when constructing the current instant or current date, and use `CarbonImmutable` when a concrete application date type is required.

## Enum casts
Cast enum-backed attributes to PHP backed enums in the model. Prefer string-backed enums for persisted domain values and store their backing values in string columns. If an integer-backed enum is required, store its backing values in an integer column.
