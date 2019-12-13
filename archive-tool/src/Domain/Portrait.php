<?php
declare(strict_types=1);

namespace PhPetra\Rep\Domain;

use JsonSerializable;
use SimpleXMLElement;

final class Portrait implements JsonSerializable
{
    /** @var string */
    private $uuid;
    /** @var string */
    private $fileUuid;
    /** @var array */
    private $stories;
    /** @var array */
    private $persons;
    /** @var string */
    private $date;


    private function __construct(
        string $uuid,
        string $fileUuid,
        string $date,
        array $stories,
        array $persons
    ) {
        $this->uuid = $uuid;
        $this->fileUuid = $fileUuid;
        $this->date = $date;
        $this->stories = $stories;
        $this->persons = $persons;
    }

    public static function fromXML(SimpleXMLElement $record): self
    {
        $stories = [];
        $persons = [];

        foreach ($record->crowdData->crowdData_record as $item) {
            if (strlen((string)$item->title) < 2) {
                continue;
            }
            $stories[] = Story::fromXML($item);

            foreach ($item->persons as $person) {
                if (strlen((string)$person->persons_record->lastName) < 2) {
                    continue;
                }
                $persons[] = Person::fromXML($person->persons_record);
            }
        }

        return new self(
            (string)$record->uuid,
            (string)$record->fileuuid,
            (string)$record->datering->datering_record,
            $stories,
            $persons
        );
    }

    public function addPerson(Person $person)
    {
        $this->persons[] = $person;
    }

    public function uuid()
    {
        return $this->uuid;
    }

    public function storyCount(): int
    {
        return count($this->stories);
    }

    public function personCount(): int
    {
        return count($this->persons);
    }

    public function JsonSerialize(): array
    {
        $stories = [];
        foreach ($this->stories as $story) {
            $stories[] = $story->JsonSerialize();
        }
        $persons = [];
        foreach ($this->persons as $person) {
            $persons[] = $person->JsonSerialize();
        }

        return [
            'uuid'    => $this->uuid,
            'uri'     => $this->portraitUri(),
            'date'    => $this->date,
            'image'   => $this->imageUri(),
            'stories' => $stories,
            'persons' => $persons,
        ];
    }

    private function portraitUri(): string
    {
        return sprintf('http://redeenportret.nl/portret/%s', $this->uuid);
    }

    private function imageUri(): string
    {
        return sprintf('http://images.memorix.nl/ams/thumb/620x500/%s.jpg', $this->fileUuid);
    }
}
