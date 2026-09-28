<?php

declare(strict_types=1);

use App\Actions\DeleteUserPasskeys;
use App\Models\Passkey;
use App\Models\User;

it('deletes only the given users passkeys', function (): void {
    $user = User::factory()->create();
    $passkey = Passkey::factory()->for($user)->create();
    $otherPasskey = Passkey::factory()->create();

    $action = resolve(DeleteUserPasskeys::class);

    $action->handle($user);

    expect($passkey->fresh())->toBeNull()
        ->and($otherPasskey->fresh())->not->toBeNull();
});
