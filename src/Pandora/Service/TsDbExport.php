<?php
/**
 * Created by IntelliJ IDEA.
 * User: wf
 * Date: 2017/12/22
 * Time: 下午4:21
 */

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