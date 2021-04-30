<?php

declare(strict_types=1);

namespace App\Dice;

use App\Dice\Dice;

class DiceGraphical extends Dice
{
    public function getLastRollGraphical()
    {
        return "<img src='../src/Dice/img/dice-six-faces-$this->roll.svg'>";
    }
}
