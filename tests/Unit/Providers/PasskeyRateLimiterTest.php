<?php

declare(strict_types=1);

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

it('throttles passkey requests by credential id when present', function (): void {
    $request = Request::create('/passkeys/login', 'POST', [
        'credential' => ['id' => 'credential-123'],
    ]);
    $request->server->set('REMOTE_ADDR', '203.0.113.42');

    $limit = RateLimiter::limiter('passkeys')($request);

    expect($limit)->toBeInstanceOf(Limit::class)
        ->and($limit->maxAttempts)->toBe(10)
        ->and($limit->key)->toBe('credential-123|203.0.113.42');
});

it('falls back to the session id when no credential id is present', function (): void {
    $request = Request::create('/passkeys/login/options', 'GET');
    $request->server->set('REMOTE_ADDR', '203.0.113.99');
    $request->setLaravelSession(resolve(Session::class));

    $limit = RateLimiter::limiter('passkeys')($request);

    expect($limit)->toBeInstanceOf(Limit::class)
        ->and($limit->maxAttempts)->toBe(10)
        ->and($limit->key)->toEndWith('|203.0.113.99')
        ->and($limit->key)->not->toStartWith('|');
});
