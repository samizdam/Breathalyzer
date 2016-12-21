<?php

namespace Datanyze;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class InputDataFileReader
{

    /**
     * @var string
     */
    private $filename;

    public function __construct(string $filename)
    {
        $this->filename = $filename;
    }

    public function getWords(): array
    {
        return preg_split('/[\s]+/', trim(file_get_contents($this->filename)));
    }
}