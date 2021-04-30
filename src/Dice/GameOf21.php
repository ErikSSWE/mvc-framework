<?php

declare(strict_types=1);

namespace App\Dice;

use App\Dice\DiceHand;

class GameOf21
{
    protected $diceHand = null;

    protected $playerScore = 0;

    protected array $data = [
        "header" => "Game21 page",
        "message" => "Test, player!",
        "playerScore" => 0,
    ];

    public function __construct()
    {

        if (empty($_SESSION["playerGames"])) {
            $_SESSION["playerGames"] = 0;
        }

        if (empty($_SESSION["howManySides"])) {
            $_SESSION["howManySides"] = 6;
        }

        if (empty($_SESSION["howManyDices"])) {
            $_SESSION["howManyDices"] = 2;
        }

        $action = strtolower($_POST["action"] ?? "");

        switch ($action) {
            case 'roll':
                $this->continueGame();
                $this->playerRoll();
                break;
            case 'start':
            case 'restart':
                $this->initGame();
                break;
            case 'end':
                $_SESSION["computerGames"] = 0;
                $_SESSION["playerGames"] = 0;
                $this->initGame();
                break;
            case 'computer':
                $this->continueGame();
                while ($_SESSION["computerScore"] < 21 && $_SESSION["computerScore"] < $_SESSION["playerScore"]) {
                    $this->computerRoll();
                }
                $this->correct();
                break;
            default:
                //echo "default";
                break;
        }
    }

    public function correct()
    {
        if ($_SESSION["playerScore"] > 21) {
            //echo "<h2> Full! Dator Vinner </h2>";
            $_SESSION["computerGames"] += 1;
        } elseif ($_SESSION["computerScore"] <= 21 && $_SESSION["computerScore"] > $_SESSION["playerScore"]) {
            //echo "<h2> Dator Vinner! </h2>";
            $_SESSION["computerGames"] += 1;
        } elseif ($_SESSION["playerScore"] <= 21 && $_SESSION["computerScore"] < $_SESSION["playerScore"]) {
            //echo "<h2> Spelare Vinner! </h2>";
            $_SESSION["playerGames"] += 1;
        } elseif ($_SESSION["computerScore"] == $_SESSION["playerScore"] && $_SESSION["playerScore"] <= 21) {
            //echo "<h2> Lika, Dator Vinner! </h2>";
            $_SESSION["computerGames"] += 1;
        } elseif ($_SESSION["computerScore"] > 21 && $_SESSION["playerScore"] <= 21) {
            //echo "<h2> Dator Full!, Spelare Vinner! </h2>";
            $_SESSION["playerGames"] += 1;
        }
    }

    public function initGame()
    {
        $_SESSION["playerScore"] = 0;
        $_SESSION["computerScore"] = 0;
        $_SESSION["howManyDices"] = (int)$_POST["howManyDices"] ?? 2;
        $_SESSION["howManySides"] = (int)$_POST["howManySides"] ?? 6;
        $this->diceHand = new DiceHand($_SESSION["howManyDices"], $_SESSION["howManySides"]);
    }

    public function continueGame()
    {
        $this->diceHand = new DiceHand(
            (int)$_SESSION["howManyDices"] ?? 2,
            (int)$_SESSION["howManySides"] ?? 6
        );
    }

    public function playerRoll()
    {
        $_SESSION["playerScore"] += $this->diceHand->rollDices();
    }

    public function computerRoll()
    {
        $_SESSION["computerScore"] += $this->diceHand->rollDices();
    }


    public function getData()
    {
        return [
            "header" => "Game21 page",
            "message" => "Test, player!",
            "howManyDices" => $_SESSION["howManyDices"] ?? 1,
            "howManySides" => $_SESSION["howManySides"] ?? 6,
            "playerScore" => $_SESSION["playerScore"] ?? 0,
            "computerScore" => $_SESSION["computerScore"] ?? 0,
            "playerGames" => $_SESSION["playerGames"] ?? 0,
            "computerGames" => $_SESSION["computerGames"] ?? 0,
        ];
    }
}
