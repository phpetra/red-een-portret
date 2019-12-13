<?php
declare(strict_types=1);


namespace PhPetra\Rep;


use Cocur\Slugify\Slugify;

final class Helper
{
    public static function fullName(array $data): string
    {
        $prefix = ' ';

        if ($data['namePrefix'] !== '') {
            $prefix .= $data['namePrefix'] . ' ';
        }
        $dates = '';
        if ($data['dates'] !== '') {
            $dates = ' (' . $data['dates'] . ')';
        }

        return trim($data['firstName'] . $prefix . $data['lastName'] . $dates);
    }

    public static function sortableName(array $data): string
    {
        $prefix = ' ';
        if ($data['namePrefix'] !== '') {
            $prefix .= $data['namePrefix'];
        }

        return trim($data['lastName'] . ', ' . $data['firstName'] . $prefix);
    }

    public static function determineLetter(array $person): string
    {
        $name = $person['lastName'] ?? null;
        $letter = null;
        if ($name) {
            $letter = strtolower(mb_substr($name, 0, 1));
        }

        if (! $letter || !ctype_alpha($letter)) {
            $letter = '_';
        }
        return $letter;
    }

    public static function determineSlug(array $person):string
    {
        $slugify = new Slugify();
        //$uri = '?letter=' . self::determineLetter($person);
        return $slugify->slugify(self::sortableName($person));
    }
}