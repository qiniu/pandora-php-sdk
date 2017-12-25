<?php

namespace Pandora\Service;


class TsDbExport extends Export
{
    public $destRepoName;
    public $series;
    public $omitInvalid;
    public $omitEmpty;
    public $fields;
    public $tags;
    public $timestamp;

    public function __construct($destRepoName, $series, array $tags, array $fields)
    {
        $this->destRepoName = $destRepoName;
        $this->series = $series;
        $this->tags = $this->srcFieldFormat($tags);
        $this->fields = $this->srcFieldFormat($fields);
    }
}