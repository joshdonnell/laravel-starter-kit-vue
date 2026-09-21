<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\User;

final readonly class UpdateUser
{
    public function __construct(
        private CreateUserEmailVerificationNotification $createUserEmailVerificationNotification,
    ) {}

    /**
     * @param  array<string, mixed>  $attributes
     */
    public function handle(User $user, array $attributes): void
    {
        $user->fill($attributes);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
            $user->save();
            $this->createUserEmailVerificationNotification->handle($user);

            return;
        }

        $user->save();
    }
}
