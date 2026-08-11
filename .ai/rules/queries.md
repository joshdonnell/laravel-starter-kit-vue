---
paths:
  - 'app/Queries/**'
---

# Queries

## Query objects
Extract Eloquent query construction into a `final readonly` class under `app/Queries` only when it is reused or complex enough that naming it provides a clear benefit. When a query object encapsulates query construction, expose it through `builder(): Builder` so the consumer can execute, paginate, or further constrain it. Keep operation orchestration and side effects in Actions.

Pass query parameters through the constructor. Keep simple, single-use Eloquent queries at their call site rather than introducing a query object without a clear benefit.
