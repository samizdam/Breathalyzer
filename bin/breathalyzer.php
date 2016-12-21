<?php
/**
 *
 */
require_once __DIR__ . '/../vendor/autoload.php';

if (empty($argv[1])) {
    echo 'use argument for input file. ' . PHP_EOL;
    exit(1);
}
$inputFilename = $argv[1];
if (!file_exists($inputFilename)) {
    echo "input file {$inputFilename} not exists. " . PHP_EOL;
    exit(1);
}

$vocabulary = (new \Datanyze\VocabularyDataFileReader(__DIR__ . '/../data/vocabulary.txt'))->getVocabulary();
$breathalyzer = new \Datanyze\Breathalyzer(new \Datanyze\LevenshteinDifferenceCalculator($vocabulary));
$words = (new \Datanyze\InputDataFileReader($inputFilename))->getWords();
echo $breathalyzer->calculateTotalDistance($words);
