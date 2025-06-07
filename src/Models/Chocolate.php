<?php

namespace App\Models;

class Chocolate {

    /**
     * Number of square pieces horizontaly.
     */
    private int $m;

    /**
     * Number of square pieces verticaly.
     */
    private int $n;

    /**
     * Horizontal cut costs.
     */
    private array $x;

    /**
     * Vertical cut costs.
     */
    private array $y;

    const MIN_SIZE = 2;  
    const MAX_SIZE = 1000;
    const MIN_COST = 1;
    const MAX_COST = 1000;


    public function __construct(int $m, int $n, array $x, array $y)
    {
        $this->m = $m;
        $this->n = $n;
        $this->x = $x;
        $this->y = $y;
    }

    /**
     * @property int $m
     * @property int $n
     * @return bool
     */
    public static function validateDimensions(int $m, int $n): bool
    {
        $min = self::MIN_SIZE;
        $max = self::MAX_SIZE;
        $validated = $m >= $min && $m <= $max && $n >= $min && $n <= $max;
        $errorMessage = "Error: m and n must be between $min and $max.\n";

        if (!$validated) {
            error($errorMessage);
        }

        return $validated;
    }

    /**
     * @property int $cost
     * @property string $dimension
     * @property int $i
     * @return bool
     */
    public static function validateCutCosts(int $cost, string $dimension = 'x', int $i = 1): bool
    {
        $min = self::MIN_COST;
        $max = self::MAX_COST;
        $validated = $cost >= $min && $cost <= $max;
        $errorMessage = "Error: {$dimension}{$i} must be between $min and $max.\n";

        if (!$validated) {
            error($errorMessage);
        }

        return $validated;
    }
    
    /**
     * Splits chocolate with min cost.
     * 
     * @return void
     */
    public function splitIntoPieces(): void
    {
        info("\nOutput:\n{$this->getMinCost()}\n\n");
    }

    /**
     * @return int
     */
    public function getMinCost(): int
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
