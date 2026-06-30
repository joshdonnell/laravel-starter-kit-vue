<?php

declare(strict_types=1);

it('renders json for unauthenticated requests that expect json', function (): void {
    $this->getJson(route('dashboard'))
        ->assertUnauthorized()
        ->assertJson(['message' => 'Unauthenticated.']);
});

it('redirects unauthenticated web requests to login', function (): void {
    $this->get(route('dashboard'))
        ->assertRedirect(route('login'));
});
