<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        $firstName = fake()->firstName();
        $lastName  = fake()->lastName();
        $name      = $firstName . ' ' . $lastName;

        return [
            'name'               => $name,
            'first_name'         => $firstName,
            'last_name'          => $lastName,
            'username'           => Str::lower(Str::slug($firstName . $lastName . fake()->numerify('##'))),
            'email'              => fake()->unique()->safeEmail(),
            'email_verified_at'  => now(),
            'password'           => Hash::make('password'),
            'bio'                => fake()->sentence(12),
            'university'         => fake()->randomElement([
                'MIT', 'Stanford University', 'Harvard University',
                'Oxford University', 'Cambridge University',
                'IIT Delhi', 'NUS Singapore', 'ETH Zurich',
                'UC Berkeley', 'University of Toronto',
            ]),
            'role'               => 'user',
            'social_links'       => null,
            'skills'             => null,
            'subjects'           => null,
        ];
    }

    public function unverified(): static
    {
        return $this->state(fn () => ['email_verified_at' => null]);
    }
}
