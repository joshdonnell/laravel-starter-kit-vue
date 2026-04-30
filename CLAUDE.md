<laravel-boost-guidelines>
=== .ai/app.actions rules ===

# App/Actions guidelines

- This application uses the Action pattern. Business logic lives in reusable, composable Action classes.
- Actions live in `app/Actions`, named based on what they do, with no suffix (e.g., `CreateUser`, not `CreateUserAction`).
- Actions are called from many different places: controllers, jobs, commands, other actions, and more.
- Actions are `final readonly` classes with a single public `handle()` method.
- Inject dependencies via constructor using private property promotion. If there are no dependencies, omit the constructor entirely.
- Wrap complex operations involving multiple models in `DB::transaction()`.
- Actions should be single-responsibility. A top-level action may compose multiple sub-actions, but each sub-action should do one thing.
- When a top-level action orchestrates multiple sub-actions, wrap the entire orchestration in `DB::transaction()`.
- Use `#[SensitiveParameter]` on password or secret string parameters.
- Create new actions with `php artisan make:action "{name}" --no-interaction`

<!-- Simple action with no dependencies -->
```php
<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\User;

final readonly class DeleteUser
{
    public function handle(User $user): void
    {
        $user->delete();
    }
}
```

<!-- Action with dependencies -->
```php
<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use SensitiveParameter;

final readonly class UpdateUserPassword
{
    public function handle(User $user, #[SensitiveParameter] string $password): void
    {
        $user->update([
            'password' => Hash::make($password),
        ]);
    }
}
```

<!-- Orchestrating action wrapping sub-actions in a transaction -->
```php
<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\DB;

final readonly class ProcessOrder
{
    public function __construct(
        private CreatePayment $createPayment,
        private SendOrderConfirmation $sendConfirmation,
    ) {}

    public function handle(User $user, array $items): Order
    {
        return DB::transaction(function () use ($user, $items): Order {
            $order = Order::query()->create([...]);

            $this->createPayment->handle($order);
            $this->sendConfirmation->handle($order);

            return $order;
        });
    }
}
```

=== .ai/general rules ===

# General Guidelines

- Don't include any superfluous PHP Annotations, except ones that start with `@` for typing variables.

=== foundation rules ===

# Laravel Boost Guidelines

The Laravel Boost guidelines are specifically curated by Laravel maintainers for this application. These guidelines should be followed closely to ensure the best experience when building Laravel applications.

## Foundational Context

This application is a Laravel application and its main Laravel ecosystems package & versions are below. You are an expert with them all. Ensure you abide by these specific packages & versions.

- php - 8.5
- inertiajs/inertia-laravel (INERTIA_LARAVEL) - v3
- laravel/fortify (FORTIFY) - v1
- laravel/framework (LARAVEL) - v13
- laravel/prompts (PROMPTS) - v0
- laravel/wayfinder (WAYFINDER) - v0
- larastan/larastan (LARASTAN) - v3
- laravel/boost (BOOST) - v2
- laravel/mcp (MCP) - v0
- laravel/pail (PAIL) - v1
- laravel/pint (PINT) - v1
- pestphp/pest (PEST) - v5
- phpunit/phpunit (PHPUNIT) - v12
- rector/rector (RECTOR) - v2

## Skills Activation

This project has domain-specific skills available. You MUST activate the relevant skill whenever you work in that domain—don't wait until you're stuck.

- `wayfinder-development` — Activates whenever referencing backend routes in frontend components. Use when importing from @/actions or @/routes, calling Laravel routes from TypeScript, or working with Wayfinder route functions.
- `pest-testing` — Use this skill for Pest PHP testing in Laravel projects only. Trigger whenever any test is being written, edited, fixed, or refactored — including fixing tests that broke after a code change, adding assertions, converting PHPUnit to Pest, adding datasets, and TDD workflows. Always activate when the user asks how to write something in Pest, mentions test files or directories (tests/Feature, tests/Unit, tests/Browser), or needs browser testing, smoke testing multiple pages for JS errors, or architecture tests. Covers: it()/expect() syntax, datasets, mocking, browser testing (visit/click/fill), smoke testing, arch(), Livewire component tests, RefreshDatabase, and all Pest 4 features. Do not use for factories, seeders, migrations, controllers, models, or non-test PHP code.
- `fortify-development` — Laravel Fortify headless authentication backend development. Activate when implementing authentication features including login, registration, password reset, email verification, two-factor authentication (2FA/TOTP), profile updates, headless auth, authentication scaffolding, or auth guards in Laravel applications.

## Conventions

- You must follow all existing code conventions used in this application. When creating or editing a file, check sibling files for the correct structure, approach, and naming.
- Use descriptive names for variables and methods. For example, `isRegisteredForDiscounts`, not `discount()`.
- Check for existing components, actions, requests, and types to reuse before writing new ones.

## Verification Scripts

- Do not create verification scripts or tinker when tests cover that functionality and prove they work. Unit and feature tests are more important.

## Application Structure & Architecture

- Stick to existing directory structure; don't create new base folders without approval.
- Do not change the application's dependencies without approval.

## Frontend Bundling

- If the user doesn't see a frontend change reflected in the UI, it could mean they need to run `npm run build`, `npm run dev`, or `composer run dev`. Ask them.

## Documentation Files

- You must only create documentation files if explicitly requested by the user.

## Replies

- Be concise in your explanations - focus on what's important rather than explaining obvious details.

=== boost rules ===

# Laravel Boost

- Laravel Boost is an MCP server that comes with powerful tools designed specifically for this application. Use them.

## Artisan Commands

- Run Artisan commands directly via the command line (e.g., `php artisan route:list`, `php artisan tinker --execute "..."`).
- Use `php artisan list` to discover available commands and `php artisan [command] --help` to check parameters.

## URLs

- Whenever you share a project URL with the user, you should use the `get-absolute-url` tool to ensure you're using the correct scheme, domain/IP, and port.

## Debugging

- Use the `database-query` tool when you only need to read from the database.
- Use the `database-schema` tool to inspect table structure before writing migrations or models.
- To execute PHP code for debugging, run `php artisan tinker --execute "your code here"` directly.
- To read configuration values, read the config files directly or run `php artisan config:show [key]`.
- To inspect routes, run `php artisan route:list` directly.
- To check environment variables, read the `.env` file directly.

## Reading Browser Logs With the `browser-logs` Tool

- You can read browser logs, errors, and exceptions using the `browser-logs` tool from Boost.
- Only recent browser logs will be useful - ignore old logs.

## Searching Documentation (Critically Important)

- Boost comes with a powerful `search-docs` tool you should use before trying other approaches when working with Laravel or Laravel ecosystem packages. This tool automatically passes a list of installed packages and their versions to the remote Boost API, so it returns only version-specific documentation for the user's circumstance. You should pass an array of packages to filter on if you know you need docs for particular packages.
- Search the documentation before making code changes to ensure we are taking the correct approach.
- Use multiple, broad, simple, topic-based queries at once. For example: `['rate limiting', 'routing rate limiting', 'routing']`. The most relevant results will be returned first.
- Do not add package names to queries; package information is already shared. For example, use `test resource table`, not `filament 4 test resource table`.

### Available Search Syntax

1. Simple Word Searches with auto-stemming - query=authentication - finds 'authenticate' and 'auth'.
2. Multiple Words (AND Logic) - query=rate limit - finds knowledge containing both "rate" AND "limit".
3. Quoted Phrases (Exact Position) - query="infinite scroll" - words must be adjacent and in that order.
4. Mixed Queries - query=middleware "rate limit" - "middleware" AND exact phrase "rate limit".
5. Multiple Queries - queries=["authentication", "middleware"] - ANY of these terms.

=== php rules ===

# PHP

- Every PHP file must start with `<?php` followed by `declare(strict_types=1);` on the next line.
- Always use curly braces for control structures, even for single-line bodies.
- Prefer `final` and `readonly` classes to prevent unintended inheritance and mutation.

## Constructors

- Use PHP 8 constructor property promotion in `__construct()`.
    - `public function __construct(private GitHub $github) { }`
- Do not allow empty `__construct()` methods with zero parameters unless the constructor is private.
- If a class has no dependencies, omit the constructor entirely.

## Type Declarations

- Always use explicit return type declarations for methods and functions.
- Use appropriate PHP type hints for method parameters.
- Use `assert()` for runtime type assertions when the type system cannot guarantee a type (e.g., after `$this->user()` on a FormRequest).

<!-- Explicit Return Types and Method Params -->
```php
protected function isAccessible(User $user, ?string $path = null): bool
{
    ...
}
```

## Enums

- Typically, keys in an Enum should be TitleCase. For example: `FavoritePerson`, `BestLake`, `Monthly`.

## Comments

- Prefer PHPDoc blocks over inline comments. Never use comments within the code itself unless the logic is exceptionally complex.

## PHPDoc Blocks

- Add useful array shape type definitions when appropriate.
- Use `@property-read` annotations on models to document attributes for static analysis.

=== models rules ===

# Models

- Models are `final class` and use `declare(strict_types=1);`.
- Use `casts()` method instead of `$casts` property for attribute casting.
- Add PHPDoc `@property-read` annotations for every attribute to help Larastan understand the model shape.
- Use `HasUuids` when the model uses UUID primary keys.
- Use proper Eloquent relationship methods with return type hints.
- Prefer relationship methods over raw queries or manual joins.
- Avoid `DB::`; prefer `Model::query()`. Generate code that leverages Laravel's ORM capabilities rather than bypassing them.
- Generate code that prevents N+1 query problems by using eager loading.
- Use Laravel's query builder for very complex database operations.

## Factories

- When creating new models, create useful factories and seeders for them too.
- Cache expensive generated values in factory definitions (e.g., `self::$password ??= Hash::make('password')`).
- Add named factory states for common variations (e.g., `unverified()`, `withoutTwoFactor()`).
- Ask the user if they need any other things, using `php artisan make:model --help` to check the available options.

=== controllers rules ===

# Controllers

- Controllers are `final readonly` classes with `declare(strict_types=1);`.
- Controllers do not contain business logic. They delegate to Actions and Form Requests.
- Controllers implement `HasMiddleware` only when they need custom middleware.
- Use `#[CurrentUser]` attribute to inject the authenticated user instead of calling `auth()->user()`.
- Return `Inertia\Response` or `Illuminate\Http\RedirectResponse` with explicit return types.
- Use named routes and the `route()` helper or `to_route()` helper.
- Use `redirect()->intended()` after login or registration.
- Use `Inertia::flash()` for toast notifications.

```php
final readonly class ProfileController
{
    public function update(UpdateUserRequest $request, #[CurrentUser] User $user, UpdateUser $action): RedirectResponse
    {
        $action->handle($user, $request->validated());

        Inertia::flash('toast', ['type' => 'success', 'message' => __('Profile updated.')]);

        return to_route('user-profile.edit');
    }
}
```

=== form-requests rules ===

# Form Requests

- Always create dedicated Form Request classes for validation. Never validate inline in controllers.
- Form requests are `final class` (not `readonly`, since they extend `FormRequest`).
- Include validation rules AND custom error messages when appropriate.
- Type the `rules()` return as `array<string, array<mixed>|string>` or `array<string, ValidationRule|array<mixed>|string>`.
- Use `assert()` after `$this->user()` to satisfy static analysis when the user type is known.
- Add custom methods to Form Requests for complex logic (e.g., `validateCredentials()`, `throttleKey()`).
- Use `$request->safe()->except()`, `$request->validated()`, `$request->string()->value()`, and `$request->boolean()` to extract typed data.

```php
final class UpdateUserRequest extends FormRequest
{
    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $user = $this->user();
        assert($user instanceof User);

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required', 'string', 'email', 'max:255',
                Rule::unique(User::class)->ignore($user->id),
            ],
        ];
    }
}
```

=== tests rules ===

# Test Enforcement

- Every change must be programmatically tested. Write a new test or update an existing test, then run the affected tests to make sure they pass.
- Run the minimum number of tests needed to ensure code quality and speed. Use `php artisan test --compact` with a specific filename or filter.
- Use `declare(strict_types=1);` in every test file.
- Prefer Pest's `it()` function over `test()`.
- Use `actingAs()` for authentication in feature tests.
- Use `fromRoute()` to set the previous URL for redirect assertions.
- Use `assertInertia()` to assert Inertia page components and props.
- Use `assertInertiaFlash()` to assert flash data sent via `Inertia::flash()`.
- Unit test Actions by resolving them with `resolve(Action::class)` and calling `->handle()` directly.
- Fake events with `Event::fake()` when testing event dispatching.
- Use factories for model creation. Check for custom states before manually setting up models.
- Faker: Use methods such as `$this->faker->word()` or `fake()->randomDigit()`. Follow existing conventions whether to use `$this->faker` or `fake()`.

```php
it('may update a user', function (): void {
    $user = User::factory()->create(['name' => 'Old Name']);

    $action = resolve(UpdateUser::class);
    $action->handle($user, ['name' => 'New Name']);

    expect($user->refresh()->name)->toBe('New Name');
});
```

=== inertia-laravel/core rules ===

# Inertia

- Inertia creates fully client-side rendered SPAs without modern SPA complexity, leveraging existing server-side patterns.
- Components live in `resources/js/pages` (unless specified in `vite.config.js`). Use `Inertia::render()` for server-side routing instead of Blade views.
- ALWAYS use `search-docs` tool for version-specific Inertia documentation and updated code examples.

# Inertia v3

- Use all Inertia features from v1, v2, and v3. Check the documentation before making changes to ensure the correct approach.
- Features: deferred props, infinite scroll, merging props, polling, prefetching, once props, flash data.
- When using deferred props, add an empty state with a pulsing or animated skeleton.
- Use `Inertia::flash()` to send flash data to the frontend (e.g., toast notifications).

=== laravel/core rules ===

# Do Things the Laravel Way

- Use `php artisan make:` commands to create new files (i.e. migrations, controllers, models, etc.). You can list available Artisan commands using `php artisan list` and check their parameters with `php artisan [command] --help`.
- If you're creating a generic PHP class, use `php artisan make:class`.
- Pass `--no-interaction` to all Artisan commands to ensure they work without user input. You should also pass the correct `--options` to ensure correct behavior.

## Database

- Always use proper Eloquent relationship methods with return type hints. Prefer relationship methods over raw queries or manual joins.
- Use Eloquent models and relationships before suggesting raw database queries.
- Avoid `DB::`; prefer `Model::query()`. Generate code that leverages Laravel's ORM capabilities rather than bypassing them.
- Generate code that prevents N+1 query problems by using eager loading.
- Use Laravel's query builder for very complex database operations.

### APIs & Eloquent Resources

- For APIs, default to using Eloquent API Resources and API versioning unless existing API routes do not, then you should follow existing application convention.

## Controllers & Validation

- Always create Form Request classes for validation rather than inline validation in controllers. Include both validation rules and custom error messages.
- Check sibling Form Requests to see if the application uses array or string based validation rules.

## Authentication & Authorization

- Use Laravel's built-in authentication and authorization features (gates, policies, Sanctum, etc.).

## URL Generation

- When generating links to other pages, prefer named routes and the `route()` function.

## Queues

- Use queued jobs for time-consuming operations with the `ShouldQueue` interface.

## Configuration

- Use environment variables only in configuration files - never use the `env()` function directly outside of config files. Always use `config('app.name')`, not `env('APP_NAME')`.

## Testing

- When creating models for tests, use the factories for the models. Check if the factory has custom states that can be used before manually setting up the model.
- Faker: Use methods such as `$this->faker->word()` or `fake()->randomDigit()`. Follow existing conventions whether to use `$this->faker` or `fake()`.
- When creating tests, make use of `php artisan make:test [options] {name}` to create a feature test, and pass `--unit` to create a unit test. Most tests should be feature tests.

## Vite Error

- If you receive an "Illuminate\Foundation\ViteException: Unable to locate file in Vite manifest" error, you can run `npm run build` or ask the user to run `npm run dev` or `composer run dev`.

=== laravel/v13 rules ===

# Laravel 13

- CRITICAL: ALWAYS use `search-docs` tool for version-specific Laravel documentation and updated code examples.
- Since Laravel 11, Laravel has a new streamlined file structure which this project uses.

## Laravel 13 Structure

- In Laravel 13, middleware are no longer registered in `app/Http/Kernel.php`.
- Middleware are configured declaratively in `bootstrap/app.php` using `Application::configure()->withMiddleware()`.
- `bootstrap/app.php` is the file to register middleware, exceptions, and routing files.
- `bootstrap/providers.php` contains application specific service providers.
- The `app/Console/Kernel.php` file no longer exists; use `bootstrap/app.php` or `routes/console.php` for console configuration.
- Console commands in `app/Console/Commands/` are automatically available and do not require manual registration.

## Database

- When modifying a column, the migration must include all of the attributes that were previously defined on the column. Otherwise, they will be dropped and lost.
- Laravel 13 allows limiting eagerly loaded records natively, without external packages: `$query->latest()->limit(10);`.

### Models

- Casts can and likely should be set in a `casts()` method on a model rather than the `$casts` property. Follow existing conventions from other models.

=== wayfinder/core rules ===

# Laravel Wayfinder

Wayfinder generates TypeScript functions for Laravel routes. Import from `@/routes/` (named routes) or `@/actions/` (controllers).

- IMPORTANT: Activate `wayfinder-development` skill whenever referencing backend routes in frontend components.
- Named Routes: `import { dashboard } from '@/routes'; dashboard()`.
- Controller Methods: `import { store } from '@/routes/register'; store()`.
- Parameter Binding: Detects route keys (`{post:slug}`) — `show({ slug: "my-post" })`.
- Query Merging: `show(1, { mergeQuery: { page: 2, sort: null } })` merges with current URL, `null` removes params.
- Inertia Forms: Use `.form()` with `<Form>` component: `v-bind="store.form()"` or `form.submit(store())` with `useForm`.

=== pint/core rules ===

# Laravel Pint Code Formatter

- If you have modified any PHP files, you must run `vendor/bin/pint --dirty --format agent` before finalizing changes to ensure your code matches the project's expected style.
- Do not run `vendor/bin/pint --test --format agent`, simply run `vendor/bin/pint --format agent` to fix any formatting issues.

=== pest/core rules ===

## Pest

- This project uses Pest for testing. Create tests: `php artisan make:test --pest {name}`.
- Run tests: `php artisan test --compact` or filter: `php artisan test --compact --filter=testName`.
- Do NOT delete tests without approval.

=== laravel/fortify rules ===

# Laravel Fortify

- Fortify is a headless authentication backend that provides authentication routes and controllers for Laravel applications.
- IMPORTANT: Always use the `search-docs` tool for detailed Laravel Fortify patterns and documentation.
- IMPORTANT: Activate `developing-with-fortify` skill when working with Fortify authentication features.

=== frontend/vue rules ===

# Vue / Inertia Frontend

- All Vue components use `<script setup lang="ts">`.
- Vue APIs (`ref`, `computed`, `onMounted`, etc.), Inertia APIs (`usePage`, `useForm`, `router`), and composables are auto-imported by `unplugin-auto-import`. Do not manually import them.
- Custom composables live in `resources/js/composables/` and are auto-imported.
- UI components live in `resources/js/components/ui/` and are auto-imported by `unplugin-vue-components`.
- shadcn-vue / reka-ui components are prefixed with `Ui` (e.g., `UiButton`, `UiLabel`).
- Reka UI primitives are prefixed with `Reka` (e.g., `RekaPrimitive`).
- Inertia components (`Link`, `Form`, `Head`) are auto-imported from `@inertiajs/vue3`.

## Wayfinder Routes

- Import named routes from `@/routes/` (e.g., `import { dashboard } from '@/routes'`).
- Import controller-specific routes from `@/routes/controller-name` (e.g., `import { edit, update } from '@/routes/user-profile'`).
- Use `.form()` on route imports for Inertia `<Form>` bindings: `v-bind="update.form()"`.
- Use `to_route()` helper in controllers, not hardcoded URLs.

## Forms

- Use Inertia's `<Form>` component with `v-bind="route.form()"`.
- Access form state via `v-slot="{ errors, processing }"`.
- Use `<InputError :message="errors.fieldName" />` to display validation errors.
- Use `reset-on-success` and `reset-on-error` props on `<Form>` to clear fields after submission.

## Layouts & Pages

- Pages live in `resources/js/pages/`.
- Layouts live in `resources/js/layouts/`.
- Wrap pages in `AppLayout` and pass `breadcrumbs` prop when applicable.
- Use `<Head title="Page Title" />` for page titles.
- Access shared Inertia data via `usePage()` and wrap derived values in `computed()`.

## Types

- TypeScript types live in `resources/js/types/`.
- Export shared types from `resources/js/types/index.ts`.
- Extend `@inertiajs/core` `InertiaConfig` interface in `global.d.ts` to type shared page props.

## Styling

- Use Tailwind CSS v4 utility classes.
- Use the `cn()` utility from `@/lib/utils` for conditional class merging (combines `clsx` and `tailwind-merge`).
- Use CSS variables for theming (defined in `resources/css/app.css`).
- Support dark mode via the `.dark` class and `dark:` variant.

=== phpstan/rules ===

# PHPStan

- PHPStan runs at level `max` (the highest strictness level) via Larastan.
- Every PHP file must satisfy level max. This means:
  - All method parameters must be typed.
  - All method return types must be explicit.
  - All properties must be typed.
  - No mixed types should leak through without explicit handling.
- Use `assert()` for runtime type narrowing when static analysis cannot infer a type.
- Add PHPDoc `@property-read` annotations on Eloquent models.
- Use precise array shape types in PHPDoc when returning arrays.

</laravel-boost-guidelines>
