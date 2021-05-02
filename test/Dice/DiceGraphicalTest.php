<?php

declare(strict_types=1);

namespace App\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for the functions in src/Dice/DiceGraphical.php.
 */
class DiceGraphicalTest extends TestCase
{
    /**
     * Test the function GetLastRollGraphical().
     */
    public function testGetLastRollGraphical()
    {
        $diceGraph = new DiceGraphical();

        $diceGraph->roll();

        $svar = $diceGraph->getLastRollGraphical();

        $this->assertIsString($svar);
    }
}
