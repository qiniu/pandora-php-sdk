<?php
/**
 * Created by IntelliJ IDEA.
 * User: wf
 * Date: 2017/12/22
 * Time: 上午10:10
 */

namespace Pandora\Service;


/**
 * {
 *  "key": <Key>,
 *  "valtype": <ValueType>,
 *  "elemtype": <ElemType>,
 *  "required": <Required>,
 *  "schema": [
 *  ...
 *  ]
 * }
 * Class PipelineSchema
 * @package Pandora\Service
 */
class PipelineSchemaEntry
{
    const VALTYPE_BOOL = 'boolean';
    const VALTYPE_LONG = 'long';
    const VALTYPE_DATE = 'date';
    const VALTYPE_FLOAT = 'float';
    const VALTYPE_STRING = 'string';
    const VALTYPE_ARRAY = 'array';
    const VALTYPE_MAP = 'map';
    const VALTYPE_JSON = 'jsonstring';

    public $key;
    public $valtype;
    public $elemtype;
    public $required;
    public $schema;

    public function __construct($key, $valtype)
    {
        $this->key = $key;
        $this->valtype = $valtype;
    }
}