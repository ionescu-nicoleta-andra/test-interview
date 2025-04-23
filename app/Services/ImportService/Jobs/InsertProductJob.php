<?php

namespace App\Services\ImportService\Jobs;

use App\Models\Produs;
use App\Services\ImportService\Inserters\ProdusArrayInserter;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class InsertProductJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $productToImport;
    protected $endOfImport;

    /**
     * Create a new job instance.
     */
    public function __construct($productToImport, $endOfImport=null)
    {
        $this->productToImport = $productToImport;
        $this->endOfImport = $endOfImport;

    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if ($this->endOfImport!==null) {

        $newProducts = Produs::where('new', true)->count();
        $stockProducts = Produs::where('stock_update', true)->count();
        $priceProducts = Produs::where('price_update', true)->count();

        Log::channel('import_feed')->info(" Imported ".$newProducts." new products ");
        Log::channel('import_feed')->info(" Updated ".$stockProducts." stock products ");
        Log::channel('import_feed')->info(" Updated ".$priceProducts." price products ");

        } else {
            $inserter = new ProdusArrayInserter($this->productToImport);
            $valid = $inserter->valid();
            if ($valid) {
                $inserter->insertInDb();
            }
        }


    }
}
