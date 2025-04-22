<?php

namespace App\Services\ImportService\Fetchers\FetcherTypes;

use App\Services\ImportService\Fetchers\Enums\Fetchers;
use App\Services\ImportService\Fetchers\Factories\FetcherFactory;
use Illuminate\Support\Facades\Storage;

abstract class BasicFetcher
{
    protected $filename;
    protected $from;
    protected $to;
    public $filepath;

    protected $fileContent;
    public function __construct($filename, $from , $to)
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

        $this->filepath = $this->to.$this->filename;
    }

    public function fetch()
    {
        $this->fileContent = $this->fetchContent();
        return $this;
    }

    public function save()
    {
        Storage::disk('local')->put($this->filepath, $this->fileContent);
        return $this;
    }

}
