<?php

declare(strict_types=1);

use Spatie\TypeScriptTransformer\Collections\TransformedCollection;
use Spatie\TypeScriptTransformer\TypeScriptTransformerConfig;

it('registers the typescript transformer configuration', function (): void {
    $config = resolve(TypeScriptTransformerConfig::class);
    $files = $config->typesWriter->output([], new TransformedCollection());

    expect($config)->toBeInstanceOf(TypeScriptTransformerConfig::class)
        ->and($config->outputDirectory)->toBe(resource_path('js/types'))
        ->and($files)->toHaveCount(1)
        ->and($files[0]->path)->toBe('generated.d.ts');
});
