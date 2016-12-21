<?php

namespace Datanyze;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class VocabularyDataFileReader
{
    /**
     * @var string
     */
    private $filename;

    public function __construct(string $filename)
    {
        $this->filename = $filename;
    }

    public function getVocabulary(): array
    {
        return array_map('strtolower', file($this->filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES));
    }
}