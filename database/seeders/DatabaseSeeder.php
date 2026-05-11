<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use App\Models\Note;
use App\Models\Tag;
use App\Models\Raise;
use App\Models\NoteComment;
use App\Models\Report;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database with a large dataset for scalability testing.
     */
    public function run(): void
    {
        // 1. Clear existing data to avoid duplicates
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        User::where('role', '!=', 'admin')->delete();
        Note::truncate();
        Tag::truncate();
        Raise::truncate();
        NoteComment::truncate();
        Report::truncate();
        DB::table('followers')->truncate();
        DB::table('note_likes')->truncate();
        DB::table('note_saves')->truncate();
        DB::table('note_tag')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 2. Create Admin
        User::updateOrCreate(
            ['email' => 'admin@sharenote.com'],
            [
                'name' => 'Admin User',
                'first_name' => 'Admin',
                'last_name' => 'User',
                'username' => 'admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        // 3. Create Categories
        $categories = [
            ['name' => 'Computer Science', 'slug' => 'computer-science', 'icon' => '💻'],
            ['name' => 'Mathematics', 'slug' => 'mathematics', 'icon' => '🔢'],
            ['name' => 'Physics', 'slug' => 'physics', 'icon' => '⚛️'],
            ['name' => 'Biology', 'slug' => 'biology', 'icon' => '🧬'],
            ['name' => 'Literature', 'slug' => 'literature', 'icon' => '📚'],
            ['name' => 'Chemistry', 'slug' => 'chemistry', 'icon' => '🧪'],
            ['name' => 'Social Science', 'slug' => 'social-science', 'icon' => '👥'],
            ['name' => 'Business Administration', 'slug' => 'business-administration', 'icon' => '📊'],
            ['name' => 'Health Science', 'slug' => 'health-science', 'icon' => '💊'],
            ['name' => 'Law', 'slug' => 'law', 'icon' => '⚖️'],
            ['name' => 'Psychology', 'slug' => 'psychology', 'icon' => '🧠'],
        ];

        foreach ($categories as $cat) {
            Category::updateOrCreate(['slug' => $cat['slug']], $cat);
        }

        // 4. Create Tags
        echo "Creating tags...\n";
        for ($i = 0; $i < 50; $i++) {
            try {
                Tag::factory()->create();
            } catch (\Exception $e) {
                // Skip duplicates
            }
        }

        // 5. Create 100 Users
        echo "Creating users...\n";
        $users = User::factory()->count(100)->create();

        // 6. Create 200 Notes
        echo "Creating notes...\n";
        $notes = Note::factory()->count(200)->create()->each(function ($note) {
            // Attach random tags
            $tags = Tag::inRandomOrder()->take(rand(1, 4))->pluck('id');
            $note->tags()->attach($tags);
        });

        // 7. Create 150 Raises (Discussions)
        echo "Creating raises...\n";
        Raise::factory()->count(150)->create();

        // 8. Create 300 Comments
        echo "Creating comments...\n";
        NoteComment::factory()->count(300)->create();

        // 9. Create 50 Reports
        echo "Creating reports...\n";
        Report::factory()->count(50)->create();

        // 10. Create random follows (Social Graph)
        echo "Creating social graph...\n";
        foreach ($users as $user) {
            // Each user follows 5-15 random people
            $toFollow = $users->random(rand(5, 15))->pluck('id');
            $user->following()->syncWithoutDetaching($toFollow);
        }

        // 11. Create random likes/saves
        echo "Creating likes and saves...\n";
        foreach ($notes as $note) {
            // Each note gets some random likes
            $likers = $users->random(rand(0, 30))->pluck('id');
            $note->likes()->syncWithoutDetaching($likers);
            
            // Each note gets some random saves
            $savers = $users->random(rand(0, 10))->pluck('id');
            $note->saves()->syncWithoutDetaching($savers);
        }

        echo "\n✅ Seeding complete! Platform is now populated with a large dataset.\n";
    }
}
