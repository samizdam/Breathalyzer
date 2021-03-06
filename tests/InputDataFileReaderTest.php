<?php

namespace Datanyze;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class InputDataFileReaderTest extends \PHPUnit_Framework_TestCase
{

    public function testGetWords()
    {
        $reader = new InputDataFileReader(__DIR__ . '/../data/example_input');
        $this->assertCount(6, $reader->getWords());
    }
}