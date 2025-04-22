<?php

namespace App\Services\ImportService\Fetchers;

use App\Services\ImportService\Fetchers\Enums\Fetchers;
use App\Services\ImportService\Fetchers\Factories\FetcherFactory;
use App\Services\ImportService\Fetchers\FetcherTypes\BasicFetcher;

use Illuminate\Support\Facades\Storage;

class FileFetcherService
{
    protected Fetchers $type_fetcher = Fetchers::LocalContentFetcher;
    protected $filename = "feed.xlsx";
    protected $from = "https://proseller.ro/feed-test.xlsx";
    protected $to = "import/";

    protected $filepath;
    protected BasicFetcher $fetcher;


    public function __construct(Fetchers $type_fetcher=null, $filename=null, $from=null , $to=null )
    {
        if(!empty($filename)) {
            $this->filename = $filename;
        }

        if(!empty($from)) {
            $this->from = $from;
        }

        if(!empty($to)) {
            $this->to = $to;
        }

        if(!empty($type_fetcher)) {
            $this->fetcher = FetcherFactory::create($type_fetcher, $this->filename, $this->from, $this->to);
        } else {
            $this->fetcher = FetcherFactory::create(Fetchers::UrlContentFetcher, $this->filename, $this->from, $this->to);
        }

        $this->filepath = $this->fetcher->filepath;
    }

    public function fetch()
    {
        $this->fetcher->fetch()->save();
    }

    public function getFilepath()
    {
        return $this->filepath;
    }

}
