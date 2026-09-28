<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Actions\SendPasswordResetLink;
use App\Http\Requests\SendPasswordResetLinkRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

final readonly class PasswordResetLinkController
{
    public function index(Request $request): Response
    {
        $status = $request->session()->get('status');

        return Inertia::render('auth/ForgotPassword', [
            'status' => is_string($status) ? $status : null,
        ]);
    }

    public function store(
        SendPasswordResetLinkRequest $request,
        SendPasswordResetLink $action
    ): RedirectResponse {
        $action->handle(['email' => $request->string('email')->lower()->value()]);

        return back()->with('status', __('A reset link will be sent if the account exists.'));
    }
}
