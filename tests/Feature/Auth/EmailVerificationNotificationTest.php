<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\Notification;

it('may send verification notification', function (): void {
    Notification::fake();

    $user = User::factory()->create([
        'email_verified_at' => null,
    ]);

    $response = $this->actingAs($user)
        ->fromRoute('verification.notice')
        ->post(route('verification.send'));

    $response->assertRedirectToRoute('verification.notice')
        ->assertSessionHas('status', 'verification-link-sent');

    Notification::assertSentTo($user, VerifyEmail::class);
});

it('redirects verified users when sending notification', function (): void {
    Notification::fake();

    $user = User::factory()->create([
        'email_verified_at' => now(),
    ]);

    $response = $this->actingAs($user)
        ->fromRoute('verification.notice')
        ->post(route('verification.send'));

    $response->assertRedirectToRoute('dashboard');

    Notification::assertNothingSent();
});
