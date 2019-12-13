<?php
declare(strict_types=1);

use PhPetra\Rep\Helper;

require_once __DIR__ . '/../vendor/autoload.php';

/**
 * Reads the json file and creates a list of names for inclusion in the "site"
 *
 */
$fileToRead = __DIR__ . '/../files/redeenportret.json';

$string = file_get_contents($fileToRead);
$portraits = json_decode($string, true);

$names = [];
// create an array to be sorted on lastName
foreach ($portraits as $portrait) {
    foreach ($portrait['persons'] as $person) {
        $name = $person['lastName'] ?? null;
        if ($name) {
            $names[Helper::sortableName($person)] = $person;
        }
    }

}

ksort($names);


$jsonNames = [];
foreach ($names as $sortName => $person) {
    $jsonNames[] = [
        'name'     => Helper::fullName($person),
        'letter'   => Helper::determineLetter($person),
        'sortName' => $sortName,
        'uri'      => Helper::determineSlug($person),
    ];
}
print json_encode($jsonNames, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
