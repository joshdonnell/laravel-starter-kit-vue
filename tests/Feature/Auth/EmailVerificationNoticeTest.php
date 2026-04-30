<?php

declare(strict_types=1);

use App\Models\User;

it('renders verify email page', function (): void {
    $user = User::factory()->create([
        'email_verified_at' => null,
    ]);

    $response = $this->actingAs($user)
        ->fromRoute('home')
        ->get(route('verification.notice'));

    $response->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('auth/VerifyEmail')
            ->has('status'));
});

it('redirects verified users to dashboard', function (): void {
    $user = User::factory()->create([
        'email_verified_at' => now(),
    ]);

    $response = $this->actingAs($user)
        ->fromRoute('home')
        ->get(route('verification.notice'));

    $response->assertRedirectToRoute('dashboard');
});
