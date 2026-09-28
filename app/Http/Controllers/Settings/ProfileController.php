<?php

declare(strict_types=1);

namespace App\Http\Controllers\Settings;

use App\Actions\DeleteUser;
use App\Actions\LogoutUser;
use App\Actions\UpdateUser;
use App\Http\Requests\DeleteUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

final readonly class ProfileController
{
    public function edit(Request $request): Response
    {
        $status = $request->session()->get('status');

        return Inertia::render('settings/Profile', [
            'status' => is_string($status) ? $status : null,
        ]);
    }

    public function update(UpdateUserRequest $request, #[CurrentUser] User $user, UpdateUser $action): RedirectResponse
    {
        $action->handle($user, $request->validated());

        Inertia::flash('toast', ['type' => 'success', 'message' => __('Profile updated.')]);

        return to_route('user-profile.edit');
    }

    public function destroy(DeleteUserRequest $request, #[CurrentUser] User $user, LogoutUser $logoutUser, DeleteUser $deleteUser): RedirectResponse
    {
        $logoutUser->handle();

        $deleteUser->handle($user);

        return to_route('home');
    }
}
