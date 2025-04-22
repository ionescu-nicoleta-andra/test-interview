<?php

namespace App\Services\ImportService\Fetchers\Factories;

use App\Services\ImportService\Fetchers\Enums\Fetchers;
use App\Services\ImportService\Fetchers\FetcherTypes\LocalContentBasicFetcher;
use App\Services\ImportService\Fetchers\FetcherTypes\URLContentBasicFetcher;


class FetcherFactory
{
    public static function create(Fetchers $type_fetcher, $filename, $from, $to)
    {
        switch ($type_fetcher){
            case Fetchers::LocalContentFetcher:
                return new LocalContentBasicFetcher($filename, $from, $to);

            case Fetchers::UrlContentFetcher:
                return new URLContentBasicFetcher($filename, $from, $to);
        }

        return new URLContentBasicFetcher();
    }
}
