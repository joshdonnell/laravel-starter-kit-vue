<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\PasskeyFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Passkeys\Passkey as BasePasskey;

/**
 * @property-read string $id
 */
final class Passkey extends BasePasskey
{
    /** @use HasFactory<PasskeyFactory> */
    use HasFactory;

    use HasUuids;
}
