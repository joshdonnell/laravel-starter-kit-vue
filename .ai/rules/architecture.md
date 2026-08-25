---
paths:
  - 'app/**'
---

# Architecture

## Workflow decoupling
Call Actions directly for application workflow orchestration. Reserve events for framework lifecycle integration rather than introducing application event and listener indirection.
