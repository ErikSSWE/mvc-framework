<?php

declare(strict_types=1);

namespace App\Dice;

use App\Dice\Dice;

class DiceHand
{
    protected array $dices = [];

    protected int $numberOfDices = 2;

    private ?int $roll = null;

    public function __construct($numberOfDices = 0, $numberOfSides = 0)
    {
        if ($numberOfDices > 0) {
            $this->numberOfDices = $numberOfDices;
        }

        for ($i = 0; $i < $this->numberOfDices; $i++) {
            $this->dices[$i] = new Dice();
            if ($numberOfSides > 0) {
                $this->dices[$i]->setSides($numberOfSides);
            }
        }
    }

    public function rollDices(): int
    {
        $this->roll = 0;
        foreach ($this->dices as $dice) {
            $this->roll += $dice->roll();
        }

        return $this->roll;
    }

    public function getLastRoll(): int
    {
        return $this->roll;
    }
}
