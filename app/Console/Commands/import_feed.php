<?php

namespace App\Console\Commands;

use App\Models\Produs;
use App\Services\ImportService\Fetchers\Enums\Fetchers;
use App\Services\ImportService\ImportFeed;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;


class import_feed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import_feed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $filename = "import_feed_".date("Y-m-d_H-i-s").".xlsx";
        $from = "https://proseller.ro/feed-test.xlsx";

        Log::channel('import_feed')->info(" Started import feed ");
        Log::channel('import_feed')->info(" From : ". $from);
        Log::channel('import_feed')->info(" Saved in file : ".$filename);


        $import = new ImportFeed(Fetchers::UrlContentFetcher, $filename, $from);
        $import->run();

        $newProducts = Produs::where('new', true)->count();
        $stockProducts = Produs::where('stock_update', true)->count();
        $priceProducts = Produs::where('price_update', true)->count();

        Log::channel('import_feed')->info(" Imported ".$newProducts." new products ");
        Log::channel('import_feed')->info(" Updated ".$stockProducts." stock products ");
        Log::channel('import_feed')->info(" Updated ".$priceProducts." price products ");
    }
}
