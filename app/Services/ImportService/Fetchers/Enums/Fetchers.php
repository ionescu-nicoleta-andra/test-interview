<?php

namespace App\Services\ImportService\Fetchers\Enums;

enum Fetchers :String
{
    case UrlContentFetcher = "UrlContentFetcher";
    case LocalContentFetcher = "LocalContentFetcher";
}
