# Controller guidelines

## Method parameter order

- Controller action methods MUST declare their parameters in this exact order:
    1. Route-model-bound models (in the order they appear in the route URI).
    2. The Form Request (or `Illuminate\Http\Request` when no Form Request exists).
    3. The authenticated user, injected with `#[CurrentUser] User $user`.
    4. Action classes, in the order they are invoked.
    5. Anything else (other injected services, optional parameters).
- Omit any slot that does not apply, but never reorder the slots that remain. A method that only needs a request and an action is `(FormRequest $request, SomeAction $action)`.
- When a route binds multiple models, keep them grouped first and match their URI order.
- Use `#[CurrentUser] User $user` to inject the authenticated user. Do not call `auth()->user()` inside the method.

@boostsnippet('Full parameter order: model, request, user, action', 'php')
<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\UpdatePost;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Container\Attributes\CurrentUser;

final readonly class PostController
{
    public function update(Post $post, UpdatePostRequest $request, #[CurrentUser] User $user, UpdatePost $action): RedirectResponse
    {
        $action->handle($post, $user, $request->validated());

        return to_route('posts.edit', $post);
    }
}
@endboostsnippet

@boostsnippet('Slots omitted: request then action only', 'php')
<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\CreateUser;
use App\Http\Requests\CreateUserRequest;
use Illuminate\Http\RedirectResponse;

final readonly class RegisterController
{
    public function store(CreateUserRequest $request, CreateUser $action): RedirectResponse
    {
        $action->handle($request->validated());

        return to_route('login');
    }
}
@endboostsnippet
