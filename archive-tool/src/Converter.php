<?php
declare(strict_types=1);

namespace PhPetra\Rep;

use PhPetra\Rep\Domain\PersonFinder;
use PhPetra\Rep\Domain\Portrait;

/**
 * Extracts UUID from XML dump into separate CSV
 */
final class Converter
{
    /** @var string */
    private $fileToRead;

    /** @var string */
    private $fileToWrite;
    /** @var PersonFinder */
    private $personFinder;

    public function __construct(
        string $fileToRead,
        string $fileToWrite,
        PersonFinder $personFinder
    ) {
        $this->fileToRead = $fileToRead;
        $this->fileToWrite = $fileToWrite;
        $this->personFinder = $personFinder;
    }

    public function run(): void
    {
        if (file_exists($this->fileToWrite)) {
            unlink($this->fileToWrite);
        }

        $xml = simplexml_load_string(file_get_contents($this->fileToRead));
        // begin json array
        file_put_contents($this->fileToWrite, '[', FILE_APPEND);
        $i = 0;
        $p = 0;
        foreach ($xml as $record) {
            $portrait = Portrait::fromXML($record);

            // attempt to find a name in the Memorix dump
            if ($portrait->personCount() < 1) {
                $personFromMemorix = $this->personFinder->findByUUID($portrait->uuid());
                if ($personFromMemorix) {
                    $portrait->addPerson($personFromMemorix);
                }
            }

            // only save those with stories
            if ($portrait->storyCount() > 0) {
                $i++;
                $delimiter = ',';
                if ($i === 1) {
                    $delimiter = '';
                }
                file_put_contents(
                    $this->fileToWrite,
                    $delimiter . json_encode($portrait, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT), FILE_APPEND
                );
            }
            // track
            if ($portrait->personCount() > 1) {
                $p++;
            }

        }
        // end json
        file_put_contents($this->fileToWrite, ']', FILE_APPEND);

        print "Added {$i} stories." . PHP_EOL;
        print "{$p} stories with multiple people." . PHP_EOL;
    }


}
