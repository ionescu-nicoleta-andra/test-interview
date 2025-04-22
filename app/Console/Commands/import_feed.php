<?php

namespace App\Console\Commands;

use App\Services\ImportService\Fetchers\Enums\Fetchers;
use App\Services\ImportService\ImportFeed;
use Illuminate\Console\Command;

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

        $import = new ImportFeed(Fetchers::UrlContentFetcher, $filename, $from);
        $import->run();
    }
}
