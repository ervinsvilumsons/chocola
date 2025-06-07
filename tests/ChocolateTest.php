<?php

use App\Models\Chocolate;
use App\Commands\ChocolaCommand;
use PHPUnit\Framework\TestCase;

class ChocolateTest extends TestCase
{
    /**
     * @return void
     */
    public function testValidateValidTestCaseInput(): void
    {
        $this->assertEquals(true, ChocolaCommand::validateTestCaseNumber(1));
    }

    /**
     * @return void
     */
    public function testValidateInvalidTestCaseInput(): void
    {
        $this->assertEquals(false, ChocolaCommand::validateTestCaseNumber(21));
    }

    /**
     * @return void
     */
    public function testValidateValidDimensionsInput(): void
    {
        $this->assertEquals(true, Chocolate::validateDimensions(2, 2));
    }

    /**
     * @return void
     */
    public function testValidateInvalidDimensionsInput(): void
    {
        $this->assertEquals(false, Chocolate::validateDimensions(1, 1));
    }

    /**
     * @return void
     */
    public function testValidateValidCutCostInput(): void
    {
        $this->assertEquals(true, Chocolate::validateCutCosts(1));
    }

    /**
     * @return void
     */
    public function testValidateInvalidCutCostInput(): void
    {
        $this->assertEquals(false, Chocolate::validateCutCosts(0));
    }

    /**
     * @return void
     */
    public function testSplit(): void
    {
        $chocolate = new Chocolate(4, 2, [2, 5, 3], [2, 1]);

        $this->assertNull($chocolate->splitIntoPieces());
    }

    /**
     * @return void
     */
    public function testBasicCase(): void
    {
        $chocolate = new Chocolate(3, 3, [2, 1], [3, 1]);
        // 3 + 4 + 2 + 3
        $this->assertEquals(12, $chocolate->getMinCost());
    }

    /**
     * @return void
     */
    public function testAllEqualCosts(): void
    {
        $chocolate = new Chocolate(4, 4, [1, 1, 1], [1, 1, 1]);
        // 1 + 1 + 1 + 4 + 4 + 4
        $this->assertEquals(15, $chocolate->getMinCost());
    }

    /**
     * @return void
     */
    public function testOnlyHorizontalCheaper(): void
    {
        $chocolate = new Chocolate(3, 3, [1, 1], [100, 100]);
        // 100 + 100 + 3 + 3
        $this->assertEquals(206, $chocolate->getMinCost());
    }

    /**
     * @return void
     */
    public function testOnlyVerticalCheaper(): void
    {
        $chocolate = new Chocolate(3, 3, [100, 100], [1, 1]);
        // 100 + 100 + 3 + 3
        $this->assertEquals(206, $chocolate->getMinCost());
    }

    /**
     * @return void
     */
    public function testLargeInput(): void
    {
        $x = array_fill(0, 999, 1000);
        $y = array_fill(0, 999, 1000);
        $chocolate = new Chocolate(1000, 1000, $x, $y);

        $this->assertIsInt($chocolate->getMinCost());
    }

    /**
     * @return void
     */
    public function testCommandRun(): void
    {
        $inputLines = [];

        $testCases = 1;
        $inputLines[] = "$testCases\n";

        for ($i = 0; $i < $testCases; $i++) {
            $m = 2;
            $n = 2;
            $inputLines[] = "$m $n\n";

            // Add m-1 x costs
            for ($j = 1; $j <= $m - 1; $j++) {
                $inputLines[] = rand(1, 100) . "\n";
            }
            // Add n-1 y costs
            for ($j = 1; $j <= $n - 1; $j++) {
                $inputLines[] = rand(1, 100) . "\n";
            }
        }

        $inputString = implode('', $inputLines);

        $inputStream = fopen('php://memory', 'r+');
        fwrite($inputStream, $inputString);
        rewind($inputStream);
        $command = new ChocolaCommand();

        $this->assertNull($command->run($inputStream));
    }
}