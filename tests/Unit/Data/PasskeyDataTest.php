<?php

declare(strict_types=1);

use App\Data\PasskeyData;
use App\Models\Passkey;

it('can be created from a Passkey model', function (): void {
    $passkey = Passkey::factory()->create([
        'name' => 'My Mac',
        'created_at' => now()->subDays(2),
        'last_used_at' => now()->subHour(),
    ]);

    expect(PasskeyData::from($passkey)->toArray())->toBe([
        'id' => $passkey->id,
        'name' => 'My Mac',
        'authenticator' => null,
        'created_at_diff' => '2 days ago',
        'last_used_at_diff' => '1 hour ago',
    ]);
});
