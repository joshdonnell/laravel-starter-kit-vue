<?php

declare(strict_types=1);

use App\Actions\CreateUser;
use Illuminate\Support\Facades\Hash;

it('may create a user', function (): void {
    $action = resolve(CreateUser::class);

    $user = $action->handle([
        'name' => 'Test User',
        'email' => 'example@email.com',
    ], 'password')->refresh();

    expect($user->name)->toBe('Test User')
        ->and($user->email)->toBe('example@email.com')
        ->and(Hash::check('password', $user->password))->toBeTrue();
});
