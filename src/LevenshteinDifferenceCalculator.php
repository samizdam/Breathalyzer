<?php

namespace Datanyze;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class LevenshteinDifferenceCalculator
{

    /**
     * @var array
     */
    private $vocabulary;

    public function __construct(array $vocabulary)
    {
        $this->vocabulary = $vocabulary;
    }

    public function calculateDistance(string $word): int
    {
        $worstCaseDistance = strlen($word);
        if ($worstCaseDistance > 255) {
            throw new \RuntimeException('Levenshtein can\'n work with strings longer than 255 characters');
        }
        $bestCaseDistance = 0;
        $bestDistance = $worstCaseDistance;
        foreach ($this->vocabulary as $item) {
            $newDistance = levenshtein($word, $item);
            if ($newDistance < $bestDistance) {
                $bestDistance = $newDistance;
            }
            if ($bestDistance === $bestCaseDistance) {
                break;
            }
        }

        return $bestDistance;
    }
}