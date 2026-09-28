<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Actions\ResetUserPassword;
use App\Http\Requests\ResetPasswordRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

final readonly class NewPasswordController
{
    public function create(Request $request): Response
    {
        return Inertia::render('auth/ResetPassword', [
            'email' => $request->string('email')->value(),
            'token' => $request->route('token'),
        ]);
    }

    public function store(ResetPasswordRequest $request, ResetUserPassword $action): RedirectResponse
    {
        $status = $action->handle($request->validated());

        throw_if($status !== Password::PASSWORD_RESET, ValidationException::withMessages([
            'email' => [__($status)],
        ]));

        return to_route('login')->with('status', __('passwords.reset'));
    }
}
