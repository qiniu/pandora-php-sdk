<?php
/**
 * Created by IntelliJ IDEA.
 * User: wf
 * Date: 2017/12/22
 * Time: 下午3:22
 */

namespace Pandora\Service;


class LogDbExport
{
    public $destRepoName;
    public $omitInvalid = false;
    public $omitEmpty = false;
    public $doc;  //array("toRepoSchema1": <#fromRepoSchema1>)

    public function __construct($destRepoName, $doc)
    {
        $this->destRepoName = $destRepoName;
        $this->doc = $doc;
    }
}