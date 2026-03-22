<?php

declare(strict_types=1);

namespace App\Data;

use Carbon\CarbonImmutable;
use Spatie\LaravelData\Data;

final class UserData extends Data
{
    public function __construct(
        public string $name,
        public string $email,
        public ?CarbonImmutable $email_verified_at
    ) {}
}
