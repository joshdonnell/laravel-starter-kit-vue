<?php

declare(strict_types=1);

use App\Data\UserData;
use App\Models\User;
use Spatie\LaravelData\Exceptions\CannotCreateData;

it('can be created with all required fields', function (): void {
    $userData = UserData::from([
        'name' => 'John Doe',
        'email' => 'john@doe.com',
    ]);

    expect($userData->toArray())->toBe([
        'name' => 'John Doe',
        'email' => 'john@doe.com',
        'email_verified_at' => null,
    ]);
});

it('errors when name is not provided', function (): void {
    expect(fn (): UserData => UserData::from([
        'email' => 'john@doe.com',
    ]))->toThrow(CannotCreateData::class);
});

it('errors when email is not provided', function (): void {
    expect(fn (): UserData => UserData::from([
        'name' => 'John Doe',
    ]))->toThrow(CannotCreateData::class);
});

it('can be created from a User model', function (): void {
    $user = User::factory()->create([
        'name' => 'John Doe',
        'email' => 'john@doe.com',
    ]);

    expect(UserData::from($user)->toArray())->toBe([
        'name' => 'John Doe',
        'email' => 'john@doe.com',
        'email_verified_at' => $user->email_verified_at?->format(DATE_ATOM),
    ]);
});
