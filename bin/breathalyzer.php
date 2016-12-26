<?php
/**
 * Example Command:
 *   `php bin/breathalyzer.php data/example_input`
 */
require_once __DIR__ . '/../vendor/autoload.php';

const VOCABULARY_FILENAME = __DIR__ . '/../data/vocabulary.txt';

$inputFilename = getInputDataFileName($argv);

$vocabularyItems = file(VOCABULARY_FILENAME, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$vocabulary = array_map('strtolower', $vocabularyItems);
$words = preg_split('/[\s]+/', trim(file_get_contents($inputFilename)));

echo calculateTotalDistanceSum($words, $vocabulary);

function calculateTotalDistanceSum(array $words, array $vocabulary): int
{
    $vocabularySortedByLength = $vocabulary;
    usort($vocabularySortedByLength, function ($a, $b) {
        if (strlen($a) === strlen($b)) {
            return 0;
        } elseif (strlen($a) < strlen($b)) {
            return -1;
        } else {
            return 1;
        }
    });
    $longestTerm = $vocabularySortedByLength[count($vocabularySortedByLength) - 1];
    $termsGroupedByLength = [];
    for ($i = 1; $i < strlen($longestTerm); $i++) {
        $termsGroupedByLength[$i] = array_filter($vocabulary, function ($item) use ($i) {
            return strlen($item) === $i;
        });
    }

    $closure = function (string $word) use ($vocabulary, $termsGroupedByLength) {
        $worstCaseDistance = $wordLength = strlen($word);
        if ($worstCaseDistance > 255) {
            throw new \RuntimeException('Levenshtein can\'n work with strings longer than 255 characters');
        }
        if (in_array($word, $termsGroupedByLength[$wordLength], true)) {
            return 0;
        }
        $bestCaseDistance = 1;
        $bestDistance = $worstCaseDistance;

        $termsShorterBy_3_Chars = $termsGroupedByLength[$wordLength - 3] ?? [];
        $termsShorterBy_2_Chars = $termsGroupedByLength[$wordLength - 2] ?? [];
        $termsShorterBy_1_Char = $termsGroupedByLength[$wordLength - 1] ?? [];
        $termsWithEqualsLength = $termsGroupedByLength[$wordLength] ?? [];
        $termsLongerBy_1_Char = $termsGroupedByLength[$wordLength + 1] ?? [];
        $termsLongerBy_2_Chars = $termsGroupedByLength[$wordLength + 2] ?? [];
        $termsLongerBy_3_Chars = $termsGroupedByLength[$wordLength + 3] ?? [];

        $nearedTerms = array_merge(
            $termsWithEqualsLength,
            $termsShorterBy_1_Char,
            $termsLongerBy_1_Char,
            $termsShorterBy_2_Chars,
            $termsLongerBy_2_Chars,
            $termsShorterBy_3_Chars,
            $termsLongerBy_3_Chars);

        foreach ($nearedTerms as $item) {
            if ($bestDistance === $bestCaseDistance) {
                return $bestCaseDistance;
            }
            $newDistance = levenshtein($word, $item);
            if ($newDistance < $bestDistance) {
                $bestDistance = $newDistance;
            }
        }

        return $bestDistance;
    };

    return array_sum(array_map($closure, $words));
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
