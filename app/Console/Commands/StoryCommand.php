<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Story;
use Carbon\Carbon;

class StoryCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'story:display';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $stories = Story::all();
        foreach($stories as $story) {
            if(Carbon::now() > Carbon::parse($story->created_at)->addHours(24)) $story->delete();
        }
        return Command::SUCCESS;
    }
}
