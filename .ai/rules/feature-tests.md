---
paths:
  - 'tests/Feature/**/*Test.php'
---

# Feature Tests

## Validation test cases
Write each request validation scenario as its own named test instead of combining fields in a dataset.

## Redirect origins
Set named previous URLs with `fromRoute()` before feature requests that exercise redirect behavior.
