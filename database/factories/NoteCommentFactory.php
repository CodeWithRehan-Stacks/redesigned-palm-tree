<?php

namespace Database\Factories;

use App\Models\NoteComment;
use App\Models\User;
use App\Models\Note;
use Illuminate\Database\Eloquent\Factories\Factory;

class NoteCommentFactory extends Factory
{
    protected $model = NoteComment::class;

    public function definition(): array
    {
        return [
            'note_id' => Note::inRandomOrder()->first()?->id ?? Note::factory(),
            'user_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
            'content' => fake()->sentence(15),
        ];
    }
}
