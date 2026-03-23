<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\CreateUserPassword;
use App\Actions\UpdateUserPassword;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\TwoFactorAuthenticationRequest;
use App\Http\Requests\UpdateUserPasswordRequest;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;
use Laravel\Fortify\Features;

final readonly class UserPasswordController implements HasMiddleware
{
    public static function middleware(): array
    {
        return Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword')
            ? [new Middleware('password.confirm', only: ['edit'])]
            : [];
    }

    public function create(Request $request): Response
    {
        return Inertia::render('auth/ResetPassword', [
            'email' => $request->email,
            'token' => $request->route('token'),
        ]);
    }

    public function store(ResetPasswordRequest $request, CreateUserPassword $action): RedirectResponse
    {
        /** @var array<string, mixed> $credentials */
        $credentials = $request->only('email', 'password', 'password_confirmation', 'token');

        $status = $action->handle(
            $credentials,
            $request->string('password')->value()
        );

        throw_if($status !== Password::PASSWORD_RESET, ValidationException::withMessages([
            'email' => [__(is_string($status) ? $status : '')],
        ]));

        return to_route('login')->with('status', __('passwords.reset'));
    }

    public function edit(TwoFactorAuthenticationRequest $request, #[CurrentUser] User $user): Response
    {
        $request->ensureStateIsValid();

        return Inertia::render('settings/Security', [
            'canManageTwoFactor' => Features::enabled(Features::twoFactorAuthentication()),
            'twoFactorEnabled' => $user->hasEnabledTwoFactorAuthentication(),
        ]);
    }

    public function update(UpdateUserPasswordRequest $request, #[CurrentUser] User $user, UpdateUserPassword $action): RedirectResponse
    {
        $action->handle($user, $request->string('password')->value());

        return back();
    }
}
