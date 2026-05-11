<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('trending:refresh')]
#[Description('Recalculate trending scores for all notes based on engagement and time decay.')]
class RefreshTrendingScores extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Refreshing trending scores...');
        
        \App\Models\Note::query()->chunkById(100, function ($notes) {
            foreach ($notes as $note) {
                $note->update([
                    'trending_score' => $note->calculateTrendingScore()
                ]);
            }
        });

        $this->info('Trending scores refreshed successfully!');
    }
}
