<?php
declare(strict_types=1);

namespace PhPetra\Rep\Domain;

use JsonSerializable;
use SimpleXMLElement;

final class Person implements JsonSerializable
{

    /** @var string */
    private $firstName;
    /** @var string */
    private $namePrefix;
    /** @var string */
    private $lastName;
    /** @var string */
    private $dates;

    private function __construct(
        string $firstName,
        string $namePrefix,
        string $lastName,
        string $dates = ''
    ) {
        $this->firstName = $firstName;
        $this->namePrefix = $namePrefix;
        $this->lastName = $lastName;
        $this->dates = $dates;
    }

    public static function fromXML(SimpleXMLElement $element)
    {
        return new self(
            (string)$element->firstName,
            (string)$element->insert,
            (string)$element->lastName
        );
    }

    public static function fromCSV(string $firstName, string $lastName, string $dates)
    {
        return new self(
            $firstName,
            '',
            $lastName,
            $dates
        );
    }

    public function jsonSerialize()
    {
        return [
            'firstName'  => $this->firstName,
            'namePrefix' => $this->namePrefix,
            'lastName'   => $this->lastName,
            'dates'      => $this->dates,
        ];
    }
}
