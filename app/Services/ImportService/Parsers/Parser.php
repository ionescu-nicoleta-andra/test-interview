<?php

namespace App\Services\ImportService\Parsers;

use App\Services\ImportService\Jobs\InsertProductJob;
use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

//TODO make it extendable for other types of readers
class Parser
{
    protected $reader;
    protected $fileType;
    protected $path;


    public function __construct(string $filepath)
    {
        $this->setPath($filepath);
        $this->setFileType();
        $this->setReader();
    }

    public function setPath(string $path)
    {
        $this->path = Storage::disk('local')->path($path);
    }

    public function setFileType()
    {
        $extension = pathinfo($this->path, PATHINFO_EXTENSION);

        if (!in_array($extension, ['xls', 'xlsx'])) {
            throw new \Exception("Invalid file extension: {$extension}");
            return;
        }

        $this->fileType = $extension;
    }

    //TODO refactor for other readers
    public function setReader()
    {
        switch ($this->fileType) {
            case "xlsx":
                $this->reader = ReaderEntityFactory::createXLSXReader();
                return;
        }
    }

    //TODO in different file Parsers
    public function parse()
    {
        switch ($this->fileType) {
            case "xlsx":
                ParserImportXLSX::parse($this->path, $this->reader);
                return;
        }
    }





}
