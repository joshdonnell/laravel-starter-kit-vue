<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Actions\LoginUser;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;

final readonly class LoginController
{
    public function index(Request $request): Response
    {
        return Inertia::render('auth/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => $request->session()->get('status'),
            'canRegister' => true,
        ]);
    }

    public function store(LoginRequest $request, LoginUser $loginUser): RedirectResponse
    {
        $user = $request->validateCredentials();

        if ($user->hasEnabledTwoFactorAuthentication()) {
            $request->session()->put([
                'login.id' => $user->getKey(),
                'login.remember' => $request->boolean('remember'),
            ]);

            return to_route('two-factor.login');
        }

        $loginUser->handle($user, $request->boolean('remember'));

        return redirect()->intended(route('dashboard', absolute: false));
    }
}
