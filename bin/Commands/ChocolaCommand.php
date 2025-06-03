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
    private function readTestCaseNumber(): int
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
     * @return array
     */
    private function readDimensions(): array
    {
        $min = Chocolate::MIN_SIZE;
        $max = Chocolate::MAX_SIZE;
        $inputMessage = "Please enter m & n dimensions:\n";
        $errorMessage = "Error: m and n must be between $min and $max.\n";

        info($inputMessage);
        while(true) {
            [$m, $n] = array_pad(explode(' ', trim(fgets(STDIN))), 2, null);
            $m = intval($m);
            $n = intval($n);

            if ($m >= $min && $m <= $max && 
                $n >= $min && $n <= $max) {
                return [$m, $n];
            }

            error($errorMessage);
        }
    }

    /**
     * @property int $m
     * @property int $n
     * @return array
     */
    private function readCutCosts(int $m, int $n): array
    {
        $min = Chocolate::MIN_COST;
        $max = Chocolate::MAX_COST;
        $x = $y = [];
        $dimensions = [
            'x' => $m,
            'y' => $n,
        ];

        foreach($dimensions as $key => $size) {
            for($i = 1; $i <= $size - 1; $i++) {
                while(true) {
                    $inputMessage = "Please enter {$key}{$i} cost:\n";
                    $errorMessage = "Error: {$key}{$i} must be between $min and $max.\n";

                    info($inputMessage);
                    $cost = intval(trim(fgets(STDIN)));

                    if ($cost >= $min && $cost <= $max) {
                        $$key[] = $cost;
                        break;
                    }

                    error($errorMessage);
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
