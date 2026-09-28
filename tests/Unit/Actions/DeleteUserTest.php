<?php

declare(strict_types=1);

use App\Actions\DeleteUser;
use App\Models\Passkey;
use App\Models\User;

it('may delete a user', function (): void {
    $user = User::factory()->create();

    $action = resolve(DeleteUser::class);

    $action->handle($user);

    expect($user->fresh())->toBeNull();
});

it('deletes the users passkeys along with the user', function (): void {
    $user = User::factory()->create();
    $passkey = Passkey::factory()->for($user)->create();

    $action = resolve(DeleteUser::class);

    $action->handle($user);

    expect($user->fresh())->toBeNull()
        ->and($passkey->fresh())->toBeNull();
});
