<?php

declare(strict_types=1);

use App\Models\User;

it('may destroy a session', function (): void {
    $user = User::factory()->create();

    $response = $this->actingAs($user)
        ->fromRoute('dashboard')
        ->post(route('logout'));

    $response->assertRedirect('/');

    $this->assertGuest();
});
