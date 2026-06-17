<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\Passkey;
use Illuminate\Support\ServiceProvider;
use Laravel\Passkeys\Passkeys;

final class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Passkeys::usePasskeyModel(Passkey::class);
    }
}
