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

@boostsnippet('Simple action with no dependencies', 'php')
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
@endboostsnippet

@boostsnippet('Action with dependencies', 'php')
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
@endboostsnippet

@boostsnippet('Orchestrating action wrapping sub-actions in a transaction', 'php')
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
@endboostsnippet
