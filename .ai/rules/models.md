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

## PHPStan properties and casts
Document every model attribute, accessor, and relationship with an accurate `@property-read` PHPDoc entry. Include generic key and value types for arrays and collections. Keep these declarations synchronized with the database schema and runtime casts.

Define an explicit public `casts(): array` method for every model. Include every persisted attribute that requires a concrete runtime type, including identifiers, strings, dates, JSON values, and enum-backed attributes. Do not rely only on inherited package casts or implicit timestamp casting.
