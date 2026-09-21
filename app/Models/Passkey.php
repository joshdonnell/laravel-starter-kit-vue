<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\CarbonInterface;
use Database\Factories\PasskeyFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Passkeys\Passkey as BasePasskey;

/**
 * @property string $id
 * @property string $user_id
 * @property string $name
 * @property string $credential_id
 * @property array<string, mixed> $credential
 * @property CarbonInterface|null $last_used_at
 * @property CarbonInterface $created_at
 * @property CarbonInterface $updated_at
 * @property-read string|null $authenticator
 * @property-read string $created_at_diff
 * @property-read string|null $last_used_at_diff
 * @property-read User $user
 */
final class Passkey extends BasePasskey
{
    /** @use HasFactory<PasskeyFactory> */
    use HasFactory;

    use HasUuids;

    /**
     * @return array<string, string>
     */
    public function casts(): array
    {
        return [
            'id' => 'string',
            'user_id' => 'string',
            'name' => 'string',
            'credential_id' => 'string',
            'credential' => 'json',
            'last_used_at' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /** @return Attribute<string, never> */
    public function createdAtDiff(): Attribute
    {
        return Attribute::make(get: fn () => $this->created_at->diffForHumans());
    }

    /** @return Attribute<string|null, never> */
    public function lastUsedAtDiff(): Attribute
    {
        return Attribute::make(get: fn () => $this->last_used_at?->diffForHumans());
    }
}
