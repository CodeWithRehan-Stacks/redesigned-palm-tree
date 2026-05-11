<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        $categories = [
            ['Computer Science', '💻'],
            ['Mathematics', '🧮'],
            ['Physics', '⚛️'],
            ['Biology', '🧬'],
            ['Chemistry', '🧪'],
            ['History', '📜'],
            ['Economics', '📊'],
            ['Psychology', '🧠'],
            ['Literature', '📚'],
            ['Geography', '🌍'],
            ['Law', '⚖️'],
            ['Business', '💼'],
        ];

        $category = fake()->unique()->randomElement($categories);

        return [
            'name' => $category[0],
            'slug' => Str::slug($category[0]),
            'icon' => $category[1],
        ];
    }
}
