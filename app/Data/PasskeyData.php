<?php

declare(strict_types=1);

namespace App\Data;

use Spatie\LaravelData\Data;

final class PasskeyData extends Data
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly ?string $authenticator,
        public readonly string $created_at_diff,
        public readonly ?string $last_used_at_diff,
    ) {}
}
