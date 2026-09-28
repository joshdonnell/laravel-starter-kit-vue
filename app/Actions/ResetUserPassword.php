<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use SensitiveParameter;

final readonly class ResetUserPassword
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public function handle(#[SensitiveParameter] array $attributes): string
    {
        $status = Password::reset(
            $attributes,
            function (User $user, #[SensitiveParameter] string $password): void {
                $user->update([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ]);
            }
        );

        assert(is_string($status));

        return $status;
    }
}
