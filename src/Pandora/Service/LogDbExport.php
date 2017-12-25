<?php
namespace Pandora\Service;


class LogDbExport extends Export
{
    public $destRepoName;
    public $omitInvalid = false;
    public $omitEmpty = false;
    public $doc;  //array("toRepoSchema1": <#fromRepoSchema1>)

    public function __construct($destRepoName, $doc)
    {
        $this->destRepoName = $destRepoName;
        $this->doc = $this->srcFieldFormat($doc);
    }
}