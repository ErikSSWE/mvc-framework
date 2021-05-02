<?php

declare(strict_types=1);

namespace App\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for the functions in src/Dice/DiceHand.php.
 * Most of the code is reused in my GameOf21 which makes
 * this tester so small because most of the code is
 * tested there.
 */
class DiceTest extends TestCase
{
    /**
     * Test the function GetLastRoll().
     */
    public function testGetLastRoll2()
    {

        $controller = new Dice();

        $controller->roll();

        $test = $controller->getLastRoll();

        $this->assertIsInt($test);
    }
}
