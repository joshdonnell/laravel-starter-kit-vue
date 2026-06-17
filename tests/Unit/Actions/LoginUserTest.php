<?php

declare(strict_types=1);

use App\Actions\LoginUser;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

it('logs the user in', function (): void {
    $user = User::factory()->create();

    $action = resolve(LoginUser::class);

    $action->handle($user);

    expect(Auth::id())->toBe($user->id);
});

it('regenerates the session to prevent fixation', function (): void {
    $user = User::factory()->create();

    $originalId = Session::getId();

    $action = resolve(LoginUser::class);

    $action->handle($user);

    expect(Session::getId())->not->toBe($originalId);
});
