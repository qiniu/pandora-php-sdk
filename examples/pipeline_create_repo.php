<?php
require_once '../autoload.php';

use Pandora\Service\PipelineService;
use Pandora\Service\PipelineSchemaEntry;
use Pandora\Auth;

$accessKey = '';
$secretKey = '';
$repoName = 'uploadtest_by_phpsdk2';
$auth = new Auth($accessKey, $secretKey);

$pipeline = new PipelineService($repoName, $auth);

$points = array(array("speed" => 12.3, "ip" => "1.2.3.1"));


$schemaEntry1 = new PipelineSchemaEntry("tname", PipelineSchemaEntry::VALTYPE_STRING);
$schemaEntry2 = new PipelineSchemaEntry("tage", PipelineSchemaEntry::VALTYPE_FLOAT);
$schema = array($schemaEntry1, $schemaEntry2);

$response = $pipeline->createRepo($schema);
print_r($response);
