<?php

namespace Database\Factories;

use App\Models\Raise;
use App\Models\User;
use App\Models\Note;
use Illuminate\Database\Eloquent\Factories\Factory;

class RaiseFactory extends Factory
{
    protected $model = Raise::class;

    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
            'note_id' => fake()->boolean(70) ? (Note::inRandomOrder()->first()?->id ?? Note::factory()) : null,
            'content' => fake()->paragraph(2),
            'quote_text' => fake()->boolean(30) ? fake()->sentence(10) : null,
            'likes_count' => fake()->numberBetween(0, 100),
            'reposts_count' => fake()->numberBetween(0, 20),
            'comments_count' => fake()->numberBetween(0, 30),
        ];
    }
}
