<?php
/**
 * Created by IntelliJ IDEA.
 * User: wf
 * Date: 2017/12/22
 * Time: 下午2:17
 */

namespace Pandora\Service;


class HttpExport extends Export
{
    public $host;
    public $uri;
    public $format = 'text';

    public function __construct($host, $uri)
    {
        $this->host = $host;
        $this->uri = $uri;
    }
}