<?php

namespace App\Services\ImportService;

use App\Services\ImportService\Fetchers\Enums\Fetchers;
use App\Services\ImportService\Fetchers\FetcherTypes\URLContentBasicFetcher;
use App\Services\ImportService\Fetchers\FileFetcherService;
use App\Services\ImportService\Inserters\ProdusArrayInserter;
use App\Services\ImportService\Jobs\InsertProductJob;
use App\Services\ImportService\Parsers\Parser;
use App\Services\ImportService\Parsers\ParserTypes\ParserXLSX;
use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;
use Illuminate\Support\Facades\Storage;

class ImportFeed
{
   protected FileFetcherService $fileFetchService;
   protected Parser $fileParserService;

   public function __construct(Fetchers $type_fetcher=null, $filename=null, $from=null)
   {
       //setting up from where and save the import file
       $this->setFileFetchService($type_fetcher, $filename, $from);
       $this->fileFetchService->fetch();
       $fileFrom = $this->fileFetchService->getFilepath();

       //setting up the parser for import
       $this->setFileParserService($fileFrom);
   }

   public function setFileFetchService(Fetchers $type_fetcher=null, $filename=null, $from=null)
   {
      $to = "import/";
      $this->fileFetchService = new FileFetcherService($type_fetcher, $filename, $from, $to);
   }

   public function setFileParserService($filepath)
   {
        $this->fileParserService = new Parser($filepath);
   }

   public function run()
   {
       $this->fileParserService->parse();
   }

}
