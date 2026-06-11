<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Laravel\Fortify\Features;

it('renders edit password page', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user)->session(['auth.password_confirmed_at' => time()]);

    $response = $this->fromRoute('dashboard')
        ->get(route('password.edit'));

    $response->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('settings/Security')
            ->has('canManageTwoFactor')
            ->has('twoFactorEnabled')
            ->where('canManagePasskeys', true)
            ->where('passkeys', []));
});

it('hides passkey props when the feature is disabled', function (): void {
    Config::set('fortify.features', [
        Features::twoFactorAuthentication([
            'confirm' => true,
            'confirmPassword' => true,
        ]),
    ]);

    $user = User::factory()->create();

    $this->actingAs($user)->session(['auth.password_confirmed_at' => time()]);

    $response = $this->fromRoute('dashboard')
        ->get(route('password.edit'));

    $response->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('settings/Security')
            ->where('canManagePasskeys', false)
            ->where('passkeys', []));
});

it('exposes the users passkeys on the security page', function (): void {
    $user = User::factory()->create();

    $passkey = $user->passkeys()->create([
        'name' => 'My Mac',
        'credential_id' => 'cred-1',
        'credential' => ['publicKey' => 'foo'],
    ]);

    $this->actingAs($user)->session(['auth.password_confirmed_at' => time()]);

    $response = $this->fromRoute('dashboard')
        ->get(route('password.edit'));

    $response->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('settings/Security')
            ->where('canManagePasskeys', true)
            ->has('passkeys', 1, fn ($p) => $p
                ->where('id', $passkey->id)
                ->where('name', 'My Mac')
                ->etc()));
});

it('may update password', function (): void {
    $user = User::factory()->create([
        'password' => Hash::make('old-password'),
    ]);

    $response = $this->actingAs($user)
        ->fromRoute('password.edit')
        ->put(route('password.update'), [
            'current_password' => 'old-password',
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ]);

    $response->assertRedirectToRoute('password.edit')
        ->assertInertiaFlash('toast', ['type' => 'success', 'message' => 'Password updated.']);

    expect(Hash::check('new-password', $user->refresh()->password))->toBeTrue();
});

it('requires current password to update', function (): void {
    $user = User::factory()->create();

    $response = $this->actingAs($user)
        ->fromRoute('password.edit')
        ->put(route('password.update'), [
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ]);

    $response->assertRedirectToRoute('password.edit')
        ->assertSessionHasErrors('current_password');
});

it('requires correct current password to update', function (): void {
    $user = User::factory()->create([
        'password' => Hash::make('old-password'),
    ]);

    $response = $this->actingAs($user)
        ->fromRoute('password.edit')
        ->put(route('password.update'), [
            'current_password' => 'wrong-password',
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ]);

    $response->assertRedirectToRoute('password.edit')
        ->assertSessionHasErrors('current_password');
});

it('requires new password to update', function (): void {
    $user = User::factory()->create([
        'password' => Hash::make('old-password'),
    ]);

    $response = $this->actingAs($user)
        ->fromRoute('password.edit')
        ->put(route('password.update'), [
            'current_password' => 'old-password',
        ]);

    $response->assertRedirectToRoute('password.edit')
        ->assertSessionHasErrors('password');
});

it('renders two factor authentication page', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user)->session(['auth.password_confirmed_at' => time()]);

    $response = $this->fromRoute('dashboard')
        ->get(route('two-factor.show'));

    $response->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('settings/Security')
            ->has('twoFactorEnabled'));
});

it('shows two factor disabled when not enabled', function (): void {
    $user = User::factory()->withoutTwoFactor()->create();

    $this->actingAs($user)->session(['auth.password_confirmed_at' => time()]);

    $response = $this->fromRoute('dashboard')
        ->get(route('two-factor.show'));

    $response->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('settings/Security')
            ->where('twoFactorEnabled', false));
});

it('shows two factor enabled when enabled', function (): void {
    $user = User::factory()->create([
        'two_factor_secret' => encrypt('secret'),
        'two_factor_recovery_codes' => encrypt(json_encode(['code1', 'code2'])),
        'two_factor_confirmed_at' => now(),
    ]);

    $this->actingAs($user)->session(['auth.password_confirmed_at' => time()]);

    $response = $this->fromRoute('dashboard')
        ->get(route('two-factor.show'));

    $response->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('settings/Security')
            ->where('twoFactorEnabled', true));
});
