<?php
declare(strict_types=1);


use PhPetra\Rep\Helper;

require_once __DIR__ . '/../vendor/autoload.php';

/** Read the JSON file and convert it to HTML */

$fileToRead = __DIR__ . '/../files/redeenportret.json';
$htmlDir = __DIR__ . '/../../html';
$fileToWrite = $htmlDir . '/%s.portraits.html';

$string = file_get_contents($fileToRead);
$portraits = json_decode($string, true);


// delete old all HTML files first
$directoryIterator = new RecursiveDirectoryIterator($htmlDir);
foreach ($directoryIterator as $fileinfo) {
    /* @var $fileinfo SplFileInfo */
    if ($fileinfo->isFile()) {
        unlink($fileinfo->getPathname());
    }
}

foreach ($portraits as $portrait) {
    foreach ($portrait['persons'] as $person) {

        $letter = Helper::determineLetter($person);

        ob_start();
        include __DIR__ . '/../templates/portrait.html.php';
        $html = ob_get_contents();
        ob_end_clean();

        file_put_contents(sprintf($fileToWrite, $letter), $html, FILE_APPEND);
    }

}
