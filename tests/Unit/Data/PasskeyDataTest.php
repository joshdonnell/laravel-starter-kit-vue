<?php

declare(strict_types=1);

use App\Data\PasskeyData;
use App\Models\Passkey;
use App\Models\User;

it('can be created with all required fields', function (): void {
    $data = new PasskeyData(
        id: 'passkey-id',
        name: 'My Mac',
        authenticator: null,
        created_at_diff: '1 day ago',
        last_used_at_diff: null,
    );

    expect($data)->toBeInstanceOf(PasskeyData::class);
});

it('can be created from a passkey model', function (): void {
    $user = User::factory()->create();

    $passkey = $user->passkeys()->create([
        'name' => 'My Mac',
        'credential_id' => 'credential-id',
        'credential' => ['publicKey' => 'public-key'],
    ]);

    $data = PasskeyData::from($passkey);

    expect($data->id)->toBe($passkey->id)
        ->and($data->name)->toBe('My Mac')
        ->and($data->authenticator)->toBeNull()
        ->and($data->created_at_diff)->toBeString()
        ->and($data->last_used_at_diff)->toBeNull();
});

it('formats the last used timestamp from the model', function (): void {
    $passkey = Passkey::factory()->create([
        'last_used_at' => now()->subHour(),
    ]);

    $data = PasskeyData::from($passkey);

    expect($data->last_used_at_diff)->toBe('1 hour ago');
});
