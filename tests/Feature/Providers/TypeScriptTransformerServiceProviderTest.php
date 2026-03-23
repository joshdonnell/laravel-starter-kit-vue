<?php

declare(strict_types=1);

use Spatie\TypeScriptTransformer\TypeScriptTransformerConfig;

it('registers the typescript transformer configuration', function (): void {
    $config = resolve(TypeScriptTransformerConfig::class);

    expect($config)->toBeInstanceOf(TypeScriptTransformerConfig::class);
});
