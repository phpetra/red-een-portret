<?php
declare(strict_types=1);

namespace PhPetra\Rep\Domain;

use JsonSerializable;
use SimpleXMLElement;

final class Story implements JsonSerializable
{
    /** @var string */
    private $title;

    /** @var string */
    private $text;

    /** @var string */
    private $created;

    /** @var string */
    private $user;

    private function __construct(
        string $title,
        string $text,
        string $created,
        string $user
    ) {
        $this->title = $title;
        $this->text = $text;
        $this->created = $created;
        $this->user = $user;
    }

    public static function fromXML(SimpleXMLElement $element)
    {
        return new self(
            (string)$element->title,
            (string)$element->story,
            (string)$element->created,
            (string)$element->username
        );
    }

    public function jsonSerialize()
    {
        return [
            'title'   => $this->title,
            'text'    => $this->text,
            'created' => $this->created,
            'user'    => $this->user,
        ];
    }
}
