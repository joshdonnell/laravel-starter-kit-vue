---
paths:
  - 'tests/**'
---

# Tests

## Database reset
Reset the database between tests with `RefreshDatabase`.

## Test collaborators
Prefer real Actions, models, database records, and other first party collaborators over mocking internal classes.

Prefer factories for reusable model setup. Direct relationship creation is acceptable for narrow associated state, and Actions may create records when creation itself is the behavior under test.

Use Laravel and Pest fakes when asserting or isolating framework side effects such as events and notifications. Global test setup should fake sleep, freeze time, and prevent stray HTTP requests and processes. A test may exercise a real framework boundary when that behavior is under test and the underlying external transport remains isolated.

Fake or mock an external system at the application's integration boundary. Do not mock first party collaborators merely to isolate a unit.
