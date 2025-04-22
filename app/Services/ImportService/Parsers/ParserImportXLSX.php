<?php

namespace App\Services\ImportService\Parsers;

use App\Services\ImportService\Jobs\InsertProductJob;
use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;

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
                    dispatch(new InsertProductJob($row));
                }
                $counterRows++;
            }
        }
        $reader->close();
        //dump($counterRows);
    }
}
