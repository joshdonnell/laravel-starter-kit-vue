<?php

declare(strict_types=1);

namespace App\Data;

use Carbon\CarbonImmutable;
use Spatie\LaravelData\Data;

final class UserData extends Data
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly ?CarbonImmutable $email_verified_at
    ) {}
}
