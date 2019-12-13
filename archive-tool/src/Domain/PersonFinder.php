<?php
declare(strict_types=1);

namespace PhPetra\Rep\Domain;

/** Searches for names in the Memorix dump, fro portraits without a crowd name */
final class PersonFinder
{
    /** @var array */
    private $people = [];

    /** @var string */
    private $file;

    public function __construct(string $file)
    {
        $this->file = $file;
    }

    public function findByUUID(string $uuid): ?Person
    {
        if (count($this->people) === 0) {
            $this->readFile();
        }

        if (array_key_exists($uuid, $this->people)) {
            return PersonExtractor::extractFromString($this->people[$uuid][5]);
        }

        return null;
    }

    private function readFile(): void
    {
        if (($handle = fopen($this->file, 'rb')) !== false) {
            while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                $this->people[$row[0]] = $row;
            }
            fclose($handle);
        }
    }

}
