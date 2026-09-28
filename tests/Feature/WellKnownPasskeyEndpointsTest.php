<?php

declare(strict_types=1);

it('advertises passkey endpoints to guests via the well-known url', function (): void {
    $response = $this->getJson('/.well-known/passkey-endpoints');

    $response->assertOk()
        ->assertExactJson([
            'enroll' => route('password.edit'),
            'manage' => route('password.edit'),
        ]);
});
