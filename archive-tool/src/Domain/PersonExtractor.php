<?php
declare(strict_types=1);

namespace PhPetra\Rep\Domain;

final class PersonExtractor
{
    /**
     * @param string $incoming
     * Rietschoten, Adrianus Antonius Marinus van (1881-1948)
     * Meijer, Puck
     * Kolk, Herman van der (1902)
     *
     * @return Person
     */
    public static function extractFromString(string $incoming): ?Person
    {
        $string = trim($incoming);

        $pattern = '/^([a-zA-Z\s]+)[,\s]*([a-zA-Z\s]*)([(0-9-)]*)$/im';
        preg_match($pattern, $string, $matches);

        if (! empty($matches)) {
            list ($full, $last, $first, $datesWithBrackets) = $matches;
            return Person::fromCSV($first, $last, $datesWithBrackets);
        }

        return null;
    }

}
