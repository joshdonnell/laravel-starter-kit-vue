---
paths:
  - 'app/Http/**'
---

# HTTP

## Input validation
Use Form Request classes for HTTP input validation. Do not validate inline in controllers.

## Typed request input
Retrieve scalar HTTP input with typed request getters such as `$request->string()` and `$request->boolean()` instead of raw input access or dynamic request properties.

## Application localization keys
Use full English sentences as translation keys for application-owned messages. Keep Laravel's dotted keys when referencing framework-provided authentication and password messages.
