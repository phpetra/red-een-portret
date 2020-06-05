<?php
declare(strict_types=1);

use PhPetra\Rep\Converter;
use PhPetra\Rep\Domain\PersonFinder;

require_once __DIR__ . '/../vendor/autoload.php';

/**
 * Replaces old redeeenportret uris with beeldbank uris
 */
$fileToRead = __DIR__ . '/../files/newuris.json';
$fileToWrite = __DIR__ . '/../files/redeenportret.orig.json';
$newFileToWrite = __DIR__ . '/../files/redeenportret.json';

$string = file_get_contents($fileToRead);
$uris = json_decode($string, true);

// make key-value pair
$pair =[];
foreach ($uris as $uri) {
    $pair[$uri['uri']] = $uri['replace_uri'];
}

$portraitString = file_get_contents($fileToWrite);
$portraits = json_decode($portraitString, true);

foreach ($portraits as &$portrait) {
    $old = $portrait['uri'];
    if (isset($pair[$old])) {
        $portrait['uri'] = $pair[$old];
        //print 'REPLACING ' . $old . ' with ' . $pair[$old] . PHP_EOL;
        print '.';
    } else {
        print 'No REPLACEMENT for ' . $old . PHP_EOL;
    }
}

file_put_contents(
    $newFileToWrite,
    json_encode($portraits, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
);
