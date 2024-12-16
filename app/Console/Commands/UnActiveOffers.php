<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use Carbon\Carbon;

class UnActiveOffers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'offer:display';

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
        $offers = Product::where("type","offer")->where("offer_active",1)->completed()->get;
        foreach($offers as $offer) {
            if(Carbon::now() > Carbon::parse($offer->created_at)->addHours($offer->offer_active_hours)) {
                $offer->update([
                    "offer_active"  => 0
                ]);
            }
        }
        return Command::SUCCESS;
    }
}
