<?php
declare(strict_types=1);

use PhPetra\Rep\Converter;
use PhPetra\Rep\Domain\PersonFinder;

require_once __DIR__ . '/../vendor/autoload.php';

$fileToRead = __DIR__ . '/../data/ams_rep_export_def.xml';
$fileToWrite = __DIR__ . '/../files/redeenportret.json';
$personFileFromMemorix = __DIR__ . '/../data/redeenportret-memorix-namen.csv';


$personFinder = new PersonFinder($personFileFromMemorix);
$extractor = new Converter($fileToRead, $fileToWrite, $personFinder);
$extractor->run();