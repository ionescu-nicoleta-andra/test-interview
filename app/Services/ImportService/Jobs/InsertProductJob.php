<?php

namespace App\Services\ImportService\Jobs;

use App\Models\Produs;
use App\Services\ImportService\Inserters\ProdusArrayInserter;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class InsertProductJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $productToImport;

    /**
     * Create a new job instance.
     */
    public function __construct($productToImport)
    {
        $this->productToImport = $productToImport;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $inserter = new ProdusArrayInserter($this->productToImport);
        $valid = $inserter->valid();
        if ($valid) {
            $inserter->insertInDb();
        }

    }
}
