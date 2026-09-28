<?php

declare(strict_types=1);

use App\Models\Passkey;
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
            ->where('canManageTwoFactor', true)
            ->where('requiresConfirmation', true)
            ->where('twoFactorEnabled', false)
            ->where('canManagePasskeys', true)
            ->where('passkeys', []));
});

it('requires password confirmation before showing the security page', function (): void {
    $user = User::factory()->create();

    $response = $this->actingAs($user)
        ->fromRoute('dashboard')
        ->get(route('password.edit'));

    $response->assertRedirectToRoute('password.confirm');
});

it('does not require two factor confirmation when the option is disabled', function (): void {
    Config::set('fortify.features', [
        Features::twoFactorAuthentication([
            'confirm' => false,
            'confirmPassword' => true,
        ]),
    ]);

    $user = User::factory()->create();

    $this->actingAs($user)->session(['auth.password_confirmed_at' => time()]);

    $response = $this->fromRoute('dashboard')
        ->get(route('password.edit'));

    $response->assertOk()
        ->assertInertia(fn ($page) => $page
            ->where('requiresConfirmation', false));
});

it('hides passkey props when the feature is disabled', function (): void {
    Config::set('fortify.features', [
        Features::twoFactorAuthentication([
            'confirm' => true,
            'confirmPassword' => true,
        ]),
    ]);

    $user = User::factory()->create();

    Passkey::factory()->for($user)->create();

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

    $passkey = Passkey::factory()->for($user)->create([
        'name' => 'My Mac',
        'created_at' => now()->subDays(2),
        'last_used_at' => now()->subHour(),
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
                ->where('authenticator', null)
                ->where('created_at_diff', '2 days ago')
                ->where('last_used_at_diff', '1 hour ago')));
});

it('redirects the legacy two factor settings url to the security page', function (): void {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/settings/two-factor');

    $response->assertRedirect(route('password.edit'));
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

it('requires matching password confirmation to update', function (): void {
    $user = User::factory()->create([
        'password' => Hash::make('old-password'),
    ]);

    $response = $this->actingAs($user)
        ->fromRoute('password.edit')
        ->put(route('password.update'), [
            'current_password' => 'old-password',
            'password' => 'new-password',
            'password_confirmation' => 'different-password',
        ]);

    $response->assertRedirectToRoute('password.edit')
        ->assertSessionHasErrors('password_confirmation')
        ->assertSessionDoesntHaveErrors('password');
});

it('shows two factor enabled when enabled', function (): void {
    $user = User::factory()->withTwoFactor()->create();

    $this->actingAs($user)->session(['auth.password_confirmed_at' => time()]);

    $response = $this->fromRoute('dashboard')
        ->get(route('password.edit'));

    $response->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('settings/Security')
            ->where('twoFactorEnabled', true));
});
