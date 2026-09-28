<?php

declare(strict_types=1);

use App\Actions\CreateUserEmailVerificationNotification;
use App\Models\User;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\Notification;

it('may send email verification notification', function (): void {
    Notification::fake();

    $user = User::factory()->unverified()->create();

    $action = resolve(CreateUserEmailVerificationNotification::class);

    $action->handle($user);

    Notification::assertSentTo($user, VerifyEmail::class);
});
