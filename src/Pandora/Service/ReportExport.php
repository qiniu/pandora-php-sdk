<?php


namespace Pandora\Service;


class ReportExport extends Export
{
    public $dbName;
    public $tableName;
    public $columns;

    public function __construct($dbName, $tableName, array $columns)
    {
        $this->dbName = $dbName;
        $this->tableName = $tableName;
        $this->columns = $this->srcFieldFormat($columns);
    }
}