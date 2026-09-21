---
paths:
  - '**/*.php'
---

# PHP

## Annotations
Do not add superfluous PHP annotations. Only add annotations beginning with `@` when they provide necessary type information.

## Global imports
Do not import a non-compound global name (`use RuntimeException;`, `use Throwable;`, `use Closure;`) in a file that has no `namespace`. Those imports have no effect and PHP warns. Pest tests are un-namespaced: write `RuntimeException::class` without a `use`. Namespaced app code may import global classes.
