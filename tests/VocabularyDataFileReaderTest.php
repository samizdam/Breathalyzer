<?php

namespace Datanyze;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class VocabularyDataFileReaderTest extends \PHPUnit_Framework_TestCase
{

    public function testGetVocabulary()
    {
        $reader = new VocabularyDataFileReader(__DIR__ . '/../data/vocabulary.txt');
        $this->assertCount(178691, $reader->getVocabulary());
    }
}