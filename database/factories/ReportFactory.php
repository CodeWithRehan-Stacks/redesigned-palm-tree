<?php

namespace Database\Factories;

use App\Models\Report;
use App\Models\User;
use App\Models\Note;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReportFactory extends Factory
{
    protected $model = Report::class;

    public function definition(): array
    {
        $note = Note::inRandomOrder()->first();
        return [
            'user_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
            'reportable_id' => $note?->id ?? 1,
            'reportable_type' => 'App\Models\Note',
            'reason' => fake()->randomElement(['Spam', 'Inappropriate content', 'Copyright violation', 'Harassment']),
            'status' => fake()->randomElement(['pending', 'reviewed', 'resolved', 'dismissed']),
        ];
    }
}
