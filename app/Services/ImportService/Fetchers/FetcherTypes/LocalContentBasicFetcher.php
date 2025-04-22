<?php

namespace App\Services\ImportService\Fetchers\FetcherTypes;

use App\Services\ImportService\Fetchers\Interfaces\FetchContentInterface;

class LocalContentBasicFetcher extends BasicFetcher implements FetchContentInterface
{
    public function fetchContent()
    {
        $content = file_get_contents($this->from);
        return $content;
    }
}
