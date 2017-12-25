<?php


namespace Pandora\Service;


class StorageExport extends Export
{
    public $bucket;
    public $keyPrefix;
    public $email;
    public $accessKey;
    public $fields;
    public $rotateStrategy;  //size|interval|both
    public $rotateSize;      //Byte Default 5242880(5MB)  Max 1073741824(1GB)
    public $rotateInterval;  //Second Default 600
    public $format;          //json|text|parquet|csv Default json
    public $delimiter;       //csv delimiter
    public $compress;        //false
    public $retention;       //file lifecycle

    const ROTATE_STRATEGY_SIZE = 'size';
    const ROTATE_STRATEGY_INTERVAL = 'interval';
    const ROTATE_STRATEGY_BOTH = 'both';

    const FILE_FORMAT_JSON = 'json';
    const FILE_FORMAT_TEXT = 'text';
    const FILE_FORMAT_PARQUET = 'parquet';
    const FILE_FORMAT_CSV = 'csv';


    public function __construct($accEmail, $bucket, $accessKey, array $fields)
    {
        $this->email = $accEmail;
        $this->bucket = $bucket;
        $this->accessKey = $accessKey;
        $this->fields = $this->srcFieldFormat($fields);
    }
}