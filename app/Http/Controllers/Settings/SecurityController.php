<?php

declare(strict_types=1);

namespace App\Http\Controllers\Settings;

use App\Actions\UpdateUserPassword;
use App\Data\PasskeyData;
use App\Http\Requests\TwoFactorAuthenticationRequest;
use App\Http\Requests\UpdateUserPasswordRequest;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Collection;
use Inertia\Inertia;
use Inertia\Response;
use Laravel\Fortify\Features;

final readonly class SecurityController implements HasMiddleware
{
    public static function middleware(): array
    {
        return Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword')
            ? [new Middleware('password.confirm', only: ['edit'])]
            : [];
    }

    public function edit(TwoFactorAuthenticationRequest $request, #[CurrentUser] User $user): Response
    {
        $request->ensureStateIsValid();

        $canManagePasskeys = Features::canManagePasskeys();

        return Inertia::render('settings/Security', [
            'canManageTwoFactor' => Features::enabled(Features::twoFactorAuthentication()),
            'requiresConfirmation' => Features::optionEnabled(Features::twoFactorAuthentication(), 'confirm'),
            'twoFactorEnabled' => $user->hasEnabledTwoFactorAuthentication(),
            'canManagePasskeys' => $canManagePasskeys,
            'passkeys' => $canManagePasskeys ? $this->passkeysFor($user) : [],
        ]);
    }

    public function update(UpdateUserPasswordRequest $request, #[CurrentUser] User $user, UpdateUserPassword $action): RedirectResponse
    {
        $action->handle($user, $request->string('password')->value());

        Inertia::flash('toast', ['type' => 'success', 'message' => __('Password updated.')]);

        return back();
    }

    /**
     * @return Collection<int, PasskeyData>
     */
    private function passkeysFor(User $user): Collection
    {
        return PasskeyData::collect(
            $user->passkeys()
                ->select(['id', 'name', 'credential', 'created_at', 'last_used_at'])
                ->latest()
                ->get(),
            Collection::class,
        );
    }
}
