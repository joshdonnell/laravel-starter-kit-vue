<?php

declare(strict_types=1);

use App\Providers\TypeScriptTransformerServiceProvider;

arch()->preset()->php();
arch()->preset()->strict()->ignoring([
    TypeScriptTransformerServiceProvider::class,
]);
arch()->preset()->security()->ignoring([
    'assert',
]);

arch('controllers')
    ->expect('App\Http\Controllers')
    ->not->toBeUsed();

//
