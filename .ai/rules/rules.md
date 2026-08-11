---
paths:
  - 'app/Rules/**'
---

# Validation Rules

## Custom rules
Implement reusable custom validation as classes under `app/Rules` using Laravel's `ValidationRule` contract and its `validate()` method. Instantiate custom rules directly in Form Request rule arrays.

Do not use inline validation closures or `Validator::extend()` for reusable domain validation.
