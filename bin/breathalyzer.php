<?php
/**
 * Example Command:
 *   `php bin/breathalyzer.php data/example_input`
 */
require_once __DIR__ . '/../vendor/autoload.php';

use Datanyze\Breathalyzer;
use Datanyze\InputDataFileReader;
use Datanyze\LevenshteinDifferenceCalculator;
use Datanyze\VocabularyDataFileReader;

const VOCABULARY_FILENAME = __DIR__ . '/../data/vocabulary.txt';

/**
 * Set to false for skip memory usage and time spent info.
 */
const SHOW_BREATHALYZER_PROFILING_INFO = true;

$inputFilename = getInputDataFileName($argv);

$startTime = microtime(true);

$vocabulary = (new VocabularyDataFileReader(VOCABULARY_FILENAME))->getVocabulary();
$words = (new InputDataFileReader($inputFilename))->getWords();
$breathalyzer = new Breathalyzer(new LevenshteinDifferenceCalculator($vocabulary));
echo $breathalyzer->calculateTotalDistance($words);

$finishTime = microtime(true);

if (SHOW_BREATHALYZER_PROFILING_INFO) {
    echo PHP_EOL . '=== Efficiency info ===' . PHP_EOL;
    $totalTimeInSec = round($finishTime - $startTime, 3);
    echo $totalTimeInSec . 'seconds spent. ' . PHP_EOL;
    echo convertBytesToMB(memory_get_usage()) . 'MB memory usage. ' . PHP_EOL;
    echo convertBytesToMB(memory_get_peak_usage()) . 'MB memory in peak usage. ' . PHP_EOL;
}

function convertBytesToMB(int $value): int
{
    return $value / 1024 / 1024;
}

function getInputDataFileName(array $argv): string
{
    if (empty($argv[1])) {
        echo 'use argument for input file. ' . PHP_EOL;
        exit(1);
    }
    $inputFilename = $argv[1];
    if (!file_exists($inputFilename)) {
        echo "input file {$inputFilename} not exists. " . PHP_EOL;
        exit(1);
    }
    return $inputFilename;
}
