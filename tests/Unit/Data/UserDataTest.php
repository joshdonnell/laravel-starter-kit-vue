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

    expect($userData)->toBeInstanceOf(UserData::class);
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
    $user = User::factory()->create();
    $userData = UserData::from($user);

    expect($userData)->toBeInstanceOf(UserData::class);
});
