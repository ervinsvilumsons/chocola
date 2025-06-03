<?php

namespace Chocola\Commands;

use Chocola\Chocolate;

class ChocolaCommand
{
    const MIN_TEST_CASE = 1;
    const MAX_TEST_CASE = 20;

    /**
     * @return int
     */
    private static function getTestCaseNumber(): int
    {
        $min = self::MIN_TEST_CASE;
        $max = self::MAX_TEST_CASE;
        $inputMessage = "Please enter number of test cases:\n";
        $errorMessage = "Error: Number of test cases must be between $min and $max.\n";

        info($inputMessage);
        while(true) {
            $testCases = intval(trim(fgets(STDIN)));

            if ($testCases >= $min && $testCases <= $max) {
                return $testCases;
            }

            error($errorMessage);
        }
    }

    /**
     * @return void
     */
    public static function run(): void
    {
        $testCases = self::getTestCaseNumber();
        info("\n");

        for ($i = 1; $i <= $testCases; $i++) {
            info("Test Case {$i}\n\n");

            $chocolate = new Chocolate();
            $chocolate->splitIntoPieces();
        }
    }
}
