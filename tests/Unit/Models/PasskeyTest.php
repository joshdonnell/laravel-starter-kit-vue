<?php

declare(strict_types=1);

use App\Models\Passkey;
use Illuminate\Support\Str;

it('creates passkeys with cast attributes', function (): void {
    $passkey = Passkey::factory()->create([
        'credential' => ['type' => 'public-key'],
        'last_used_at' => now()->subHour(),
    ])->refresh();

    expect(Str::isUuid($passkey->id))->toBeTrue()
        ->and(Str::isUuid($passkey->user_id))->toBeTrue()
        ->and($passkey->credential)->toBe(['type' => 'public-key'])
        ->and($passkey->last_used_at?->timestamp)->toBe(now()->subHour()->timestamp)
        ->and($passkey->created_at->timestamp)->toBe(now()->timestamp)
        ->and($passkey->updated_at->timestamp)->toBe(now()->timestamp);
});

it('formats relative timestamps', function (): void {
    $passkey = Passkey::factory()->create([
        'created_at' => now()->subDays(2),
        'last_used_at' => now()->subHour(),
    ]);

    $unusedPasskey = Passkey::factory()->create([
        'last_used_at' => null,
    ]);

    expect($passkey->created_at_diff)->toBe('2 days ago')
        ->and($passkey->last_used_at_diff)->toBe('1 hour ago')
        ->and($unusedPasskey->last_used_at_diff)->toBeNull();
});
