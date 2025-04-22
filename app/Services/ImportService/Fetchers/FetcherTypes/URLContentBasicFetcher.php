<?php

namespace App\Services\ImportService\Fetchers\FetcherTypes;

use App\Services\ImportService\Fetchers\Interfaces\FetchContentInterface;
use GuzzleHttp\Client;

class URLContentBasicFetcher extends BasicFetcher implements FetchContentInterface
{
    public function fetchContent()
    {
        $client = new Client();
        $response = $client->get($this->from);
        return  $response->getBody()->getContents();
    }
}
