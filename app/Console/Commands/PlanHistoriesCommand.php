<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
// Carbon
use Carbon\Carbon;
// Models
use App\Models\Store\History;
use App\Models\Product;

class PlanHistoriesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'planHistories:display';

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
        $histories  = History::where(["active"=>1,"end"=>0])->get();
        $ids        = [];
        foreach($histories as $history) {
            if(Carbon::now() > Carbon::parse($history->end_date)) {
                $ids[] = $history->id;
                \App\Models\User::where("id",$history->user_id)->update(["plan_start_at"=>null]);
            }
        }
        History::whereIn("id",$ids)->update([
            "active"    => 0,
            "end"       => 1
        ]);
        $storeIDS = History::whereIn("id",$ids)->pluck("user_id")->toArray();
        Product::whereIn("store_id",$storeIDS)->update([
            "plan_suspend" => 1
        ]);
        return Command::SUCCESS;
    }
}
