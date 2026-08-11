---
paths:
  - 'app/Http/Controllers/**'
---

# Controllers

## Method parameter order
Controller action methods must declare parameters in this order:

1. Route model bound models, in route URI order.
2. The Form Request, or `Illuminate\Http\Request` when no Form Request exists.
3. The authenticated user, injected as `#[CurrentUser] User $user`.
4. Action classes, in invocation order.
5. Other services or optional parameters.

Omit slots that do not apply, but never reorder the remaining slots. Keep multiple route model bound models grouped in route URI order.

Use `#[CurrentUser] User $user` to inject the authenticated user. Do not call `auth()->user()` inside controller methods.
