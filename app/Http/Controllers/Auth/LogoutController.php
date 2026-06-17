<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Actions\LogoutUser;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

final readonly class LogoutController
{
    public function __invoke(Request $request, LogoutUser $logoutUser): RedirectResponse
    {
        $logoutUser->handle($request);

        return redirect('/');
    }
}
