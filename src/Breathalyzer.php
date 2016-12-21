<?php

namespace Datanyze;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class Breathalyzer
{

    /**
     * @var LevenshteinDifferenceCalculator
     */
    private $differenceCalculator;

    public function __construct(LevenshteinDifferenceCalculator $differenceCalculator)
    {
        $this->differenceCalculator = $differenceCalculator;
    }

    public function calculateTotalDistance(array $words)
    {
        return array_sum(array_map(function ($word) {
            return $this->differenceCalculator->calculateDistance($word);
        }, $words));
    }
}