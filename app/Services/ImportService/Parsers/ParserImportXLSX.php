<?php

namespace App\Services\ImportService\Parsers;

use App\Services\ImportService\Jobs\InsertProductJob;
use Illuminate\Support\Facades\Log;

class ParserImportXLSX
{
    public static function parse($path, $reader)
    {
        $reader->open($path);
        $counterRows=0;
        # read each cell of each row of each sheet
        foreach ($reader->getSheetIterator() as $sheet) {
            foreach ($sheet->getRowIterator() as $row) {
                if ($counterRows != 0) {
                    dispatch(new InsertProductJob($row, null));
                }
                $counterRows++;
            }
        }
        $reader->close();

        dispatch(new InsertProductJob([], "end_of_import"));

        Log::channel('import_feed')->info(" Parsed ".$counterRows." lines.");
        Log::channel('import_feed')->info(" Parser ended  at : ". date("Y-m-d H:i:s"));
    }
}
