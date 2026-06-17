<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Actions\CreateUserEmailVerificationNotification;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

final readonly class EmailVerificationNotificationController
{
    public function __invoke(Request $request, #[CurrentUser] User $user, CreateUserEmailVerificationNotification $action): RedirectResponse
    {
        if ($user->hasVerifiedEmail()) {
            return redirect()->intended(route('dashboard', absolute: false));
        }

        $action->handle($user);

        return back()->with('status', 'verification-link-sent');
    }
}
