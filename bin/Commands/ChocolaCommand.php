<?php

namespace App\Commands;

use App\Models\Chocolate;

class ChocolaCommand
{
    const MIN_TEST_CASE = 1;
    const MAX_TEST_CASE = 20;

    /**
     * @param int $number
     * @return @bool
     */
    public static function validateTestCaseNumber(int $number): bool
    {
        $min = self::MIN_TEST_CASE;
        $max = self::MAX_TEST_CASE;
        $errorMessage = "Error: Number of test cases must be between $min and $max.\n";
        $validated = $number >= $min && $number <= $max;

        if (!$validated) {
            error($errorMessage);
        }

        return $validated;
    }

    /**
     * @param STDIN $input
     * @return int
     */
    private function readTestCaseNumber($input = STDIN): int
    {
        info("Please enter number of test cases:\n");
        while(true) {
            $testCases = intval(trim(fgets($input)));

            if (self::validateTestCaseNumber($testCases)) {
                return $testCases;
            }
        }
    }

    /**
     * @param STDIN $input
     * @return array
     */
    private function readDimensions($input = STDIN): array
    {
        info("Please enter m & n dimensions:\n");
        while(true) {
            [$m, $n] = array_pad(explode(' ', trim(fgets($input))), 2, null);
            $m = intval($m);
            $n = intval($n);

            if (Chocolate::validateDimensions($m, $n)) {
                return [$m, $n];
            }
        }
    }

    /**
     * @param int $m
     * @param int $n
     * @param STDIN $input
     * @return array
     */
    private function readCutCosts(int $m, int $n, $input = STDIN): array
    {
        $x = $y = [];
        $dimensions = [
            'x' => $m,
            'y' => $n,
        ];

        foreach($dimensions as $key => $size) {
            for($i = 1; $i <= $size - 1; $i++) {
                info("Please enter {$key}{$i} cost:\n");
                while(true) {
                    $cost = intval(trim(fgets($input)));

                    if (Chocolate::validateCutCosts($cost, $key, $i)) {
                        $$key[] = $cost;
                        break;
                    }
                }
            }
        }

        return [$x, $y];
    }

    /**
     * @param STDIN $input
     * @return bool
     */
    public function run($input = STDIN): bool
    {
        $testCases = self::readTestCaseNumber($input);
        info("\n");

        for ($i = 1; $i <= $testCases; $i++) {
            info("Test Case {$i}\n\n");
            [$m, $n] = $this->readDimensions($input);
            [$x, $y] = $this->readCutCosts($m, $n, $input);
            $chocolate = new Chocolate($m, $n, $x, $y);
            $chocolate->splitIntoPieces();
        }

        return true;
    }
}
