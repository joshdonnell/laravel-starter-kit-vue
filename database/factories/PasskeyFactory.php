<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Passkey;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Passkey>
 */
final class PasskeyFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'name' => fake()->words(2, true),
            'credential_id' => fake()->unique()->sha256(),
            'credential' => ['type' => 'public-key'],
            'last_used_at' => null,
        ];
    }
}
