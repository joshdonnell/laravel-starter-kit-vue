<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Actions\LogoutUser;
use Illuminate\Http\RedirectResponse;

final readonly class LogoutController
{
    public function __invoke(LogoutUser $logoutUser): RedirectResponse
    {
        $logoutUser->handle();

        return to_route('home');
    }
}
