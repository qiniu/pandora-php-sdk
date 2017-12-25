<?php
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