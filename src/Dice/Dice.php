<?php

declare(strict_types=1);

namespace App\Dice;

class Dice
{

    protected int $sides = 6;

    protected ?int $roll = null;

    public function roll(): int
    {
        $this->roll = rand(1, $this->sides);

        return $this->roll;
    }

    public function getLastRoll(): int
    {
        return $this->roll;
    }

    public function setSides(int $sides): void
    {
        $this->sides = $sides;
    }
}
