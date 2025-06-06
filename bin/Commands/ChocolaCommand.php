<?php

namespace Chocola\Commands;

use Chocola\Chocolate;

class ChocolaCommand
{
    const MIN_TEST_CASE = 1;
    const MAX_TEST_CASE = 20;

    /**
     * @property int $number
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
     * @return int
     */
    private function readTestCaseNumber(): int
    {
        info("Please enter number of test cases:\n");
        while(true) {
            $testCases = intval(trim(fgets(STDIN)));

            if (self::validateTestCaseNumber($testCases)) {
                return $testCases;
            }
        }
    }

    /**
     * @return array
     */
    private function readDimensions(): array
    {
        info("Please enter m & n dimensions:\n");
        while(true) {
            [$m, $n] = array_pad(explode(' ', trim(fgets(STDIN))), 2, null);
            $m = intval($m);
            $n = intval($n);

            if (Chocolate::validateDimensions($m, $n)) {
                return [$m, $n];
            }
        }
    }

    /**
     * @property int $m
     * @property int $n
     * @return array
     */
    private function readCutCosts(int $m, int $n): array
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
                    $cost = intval(trim(fgets(STDIN)));

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
     * @return void
     */
    public function run(): void
    {
        $testCases = self::readTestCaseNumber();
        info("\n");

        for ($i = 1; $i <= $testCases; $i++) {
            info("Test Case {$i}\n\n");
            [$m, $n] = $this->readDimensions();
            [$x, $y] = $this->readCutCosts($m, $n);
            $chocolate = new Chocolate($m, $n, $x, $y);
            $chocolate->splitIntoPieces();
        }
    }
}
