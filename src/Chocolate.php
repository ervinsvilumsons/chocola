<?php

namespace Chocola;

class Chocolate {

    /**
     * Number of square pieces horizontaly.
     */
    public int $m = 0;

    /**
     * Number of square pieces verticaly.
     */
    public int $n = 0;

    /**
     * Horizontal cut costs.
     */
    public array $x = [];

    /**
     * Vertical cut costs.
     */
    public array $y = [];

    const MIN_SIZE = 2;  
    const MAX_SIZE = 1000;
    const MIN_COST = 1;
    const MAX_COST = 1000;

 
    /**
     * Splits chocolate with min cost.
     * 
     * @return void
     */
    public function splitIntoPieces(): void
    {
        $this->getDimensions();
        $this->getCutCosts();
        $minCost = $this->getMinCost();

        info("\nOutput:\n{$minCost}\n\n");
    }

    /**
     * @return true
     */
    private function getDimensions(): true
    {
        $min = self::MIN_SIZE;
        $max = self::MAX_SIZE;
        $inputMessage = "Please enter m & n dimensions:\n";
        $errorMessage = "Error: m and n must be between $min and $max.\n";

        info($inputMessage);
        while(true) {
            [$m, $n] = array_pad(explode(' ', trim(fgets(STDIN))), 2, null);
            $this->m = intval($m);
            $this->n = intval($n);

            if ($this->m >= $min && $this->m <= $max && $this->n >= $min && $this->n <= $max) {
                return true;
            }

            error($errorMessage);
        }
    }

    /**
     * @return void
     */
    private function getCutCosts(): void
    {
        $min = self::MIN_COST;
        $max = self::MAX_COST;
        $dimensions = [
            'x' => $this->m,
            'y' => $this->n,
        ];

        foreach($dimensions as $key => $size) {
            for($i = 1; $i <= $size - 1; $i++) {
                while(true) {
                    $inputMessage = "Please enter {$key}{$i} cost:\n";
                    $errorMessage = "Error: {$key}{$i} must be between $min and $max.\n";

                    info($inputMessage);
                    $cost = intval(trim(fgets(STDIN)));

                    if ($cost >= $min && $cost <= $max) {
                        $this->$key[] = $cost;
                        break;
                    }

                    error($errorMessage);
                }
            }
        }
    }

    /**
     * @return int
     */
    private function getMinCost(): int
    {
        $totalCost = $hCuts = $vCuts = 0;
        $hPieces = 1;
        $vPieces = 1;

        // Start with most expensive cuts first, because we have less pieces
        rsort($this->x);
        rsort($this->y);

        while ($hCuts < $this->m - 1 && $vCuts < $this->n - 1) {
            if ($this->x[$hCuts] > $this->y[$vCuts]) {
                $totalCost += $this->x[$hCuts++] * $vPieces;
                $hPieces++;
            } else {
                $totalCost += $this->y[$vCuts++] * $hPieces;
                $vPieces++;
            }
        }

        // Remaining horizontal cuts left
        while ($hCuts < $this->m - 1) $totalCost += $this->x[$hCuts++] * $vPieces;

        // Remaining vertical cuts left
        while ($vCuts < $this->n - 1) $totalCost += $this->y[$vCuts++] * $hPieces;

        return $totalCost;
    }
}
