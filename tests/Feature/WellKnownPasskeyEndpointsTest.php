<?php

declare(strict_types=1);

it('advertises passkey endpoints via the well-known url', function (): void {
    $response = $this->getJson(route('well-known.passkeys'));

    $response->assertOk()
        ->assertExactJson([
            'enroll' => route('two-factor.show'),
            'manage' => route('two-factor.show'),
        ]);
});

it('exposes the well-known passkey endpoints to guests', function (): void {
    $this->getJson('/.well-known/passkey-endpoints')->assertOk();
});
