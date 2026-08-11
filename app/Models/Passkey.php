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
 * @property-read string $id
 * @property-read string $user_id
 * @property-read string $name
 * @property-read string $credential_id
 * @property-read array<string, mixed> $credential
 * @property-read CarbonInterface|null $last_used_at
 * @property-read CarbonInterface $created_at
 * @property-read CarbonInterface $updated_at
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

    protected function createdAtDiff(): Attribute
    {
        return Attribute::make(get: fn () => $this->created_at->diffForHumans());
    }

    protected function lastUsedAtDiff(): Attribute
    {
        return Attribute::make(get: fn () => $this->last_used_at?->diffForHumans());
    }
}
