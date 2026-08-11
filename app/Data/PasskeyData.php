<?php

declare(strict_types=1);

namespace App\Data;

use Carbon\CarbonImmutable;
use Spatie\LaravelData\Attributes\Hidden as DataHidden;
use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\Hidden as TypeScriptHidden;

final class PasskeyData extends Data
{
    public readonly string $created_at_diff;

    public readonly ?string $last_used_at_diff;

    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly ?string $authenticator,
        #[DataHidden, TypeScriptHidden]
        public readonly CarbonImmutable $created_at,
        #[DataHidden, TypeScriptHidden]
        public readonly ?CarbonImmutable $last_used_at,
    ) {
        $this->created_at_diff = $created_at->diffForHumans();
        $this->last_used_at_diff = $last_used_at?->diffForHumans();
    }
}
