<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\User;

final readonly class DeleteUserPasskeys
{
    public function handle(User $user): void
    {
        $user->passkeys()->delete();
    }
}
