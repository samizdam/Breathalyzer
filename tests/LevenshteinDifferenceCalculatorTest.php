<?php

namespace Datanyze;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class LevenshteinDifferenceCalculatorTest extends \PHPUnit_Framework_TestCase
{

    public function testCalculateDistanceWithWorstCase()
    {
        $vocabulary = ['foo'];
        $calculator = new LevenshteinDifferenceCalculator($vocabulary);
        $this->assertSame(3, $calculator->calculateDistance('bar'));
    }

    public function testCalculateDistanceWithBestCase()
    {
        $vocabulary = ['foo', 'bar'];
        $calculator = new LevenshteinDifferenceCalculator($vocabulary);
        $this->assertSame(0, $calculator->calculateDistance('bar'));
    }

    public function testCalculateDistanceWithMiddleCase()
    {
        $vocabulary = ['foo', 'barr'];
        $calculator = new LevenshteinDifferenceCalculator($vocabulary);
        $this->assertSame(1, $calculator->calculateDistance('bar'));
    }
}