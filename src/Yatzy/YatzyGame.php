<?php

declare(strict_types=1);

namespace App\Yatzy;

use App\Dice\DiceHand;

class YatzyGame
{
    protected $diceHand = null;

    protected $hand = [
        "throws" => "",
        "dices" => [
            1 => 0,
            2 => 0,
            3 => 0,
            4 => 0,
            5 => 0,
        ]
    ];

    public function __construct()
    {

        $this->hand["throws"] = $_SESSION["rolls"] ?? 0;
        $this->hand["dices"][1] = $_SESSION["dice1"] ?? 0;
        $this->hand["dices"][2] = $_SESSION["dice2"] ?? 0;
        $this->hand["dices"][3] = $_SESSION["dice3"] ?? 0;
        $this->hand["dices"][4] = $_SESSION["dice4"] ?? 0;
        $this->hand["dices"][5] = $_SESSION["dice5"] ?? 0;

        $_SESSION["message"] = $this->hand["dices"][1];


        $action = strtolower($_POST["action"] ?? "");

        switch ($action) {
            case 'nästa':
                if ($_SESSION["number"] <= 6) {
                    $this->setScore();
                    $_SESSION["rolls"] = 0;
                    $_SESSION["number"] += 1;
                }
                $_SESSION["message"] = "Spelet är nu avklarat!";
                break;
            case 'slå':
                $this->continueGame();
                break;
            case 'starta':
                $this->startaGame();
                break;
        }
    }

    public function setScore()
    {
        foreach ($this->hand["dices"] as $value) {
            if ($value == $_SESSION["number"]) {
                $_SESSION["Score" . $_SESSION["number"]] += $value;
            }
        }
        $_SESSION["dice1"] = 0;
        $_SESSION["dice2"] = 0;
        $_SESSION["dice3"] = 0;
        $_SESSION["dice4"] = 0;
        $_SESSION["dice5"] = 0;
    }

    public function startaGame()
    {
        $_SESSION["rolls"] = 0;
        $_SESSION["dice1"] = 0;
        $_SESSION["dice2"] = 0;
        $_SESSION["dice3"] = 0;
        $_SESSION["dice4"] = 0;
        $_SESSION["dice5"] = 0;
        $_SESSION["number"] = 1;
        $_SESSION["Score1"] = 0;
        $_SESSION["Score2"] = 0;
        $_SESSION["Score3"] = 0;
        $_SESSION["Score4"] = 0;
        $_SESSION["Score5"] = 0;
        $_SESSION["Score6"] = 0;
    }


    public function continueGame()
    {
        if ($_SESSION["rolls"] < 3) {
            $this->dices();
            $_SESSION["rolls"] += 1;
        }
        $_SESSION["message"] = $_SESSION["number"];
    }


    public function dices()
    {
        if (isset($_POST['dice1']) && $_POST['dice1'] === "1") {
            $_SESSION["dice1"] = rand(1, 6);
        }

        if (isset($_POST['dice2']) && $_POST['dice2'] === "1") {
            $_SESSION["dice2"] = rand(1, 6);
        }

        if (isset($_POST['dice3']) && $_POST['dice3'] === "1") {
            $_SESSION["dice3"] = rand(1, 6);
        }

        if (isset($_POST['dice4']) && $_POST['dice4'] === "1") {
            $_SESSION["dice4"] = rand(1, 6);
        }

        if (isset($_POST['dice5']) && $_POST['dice5'] === "1") {
            $_SESSION["dice5"] = rand(1, 6);
        }
    }

    public function getData()
    {
        return [
            "title" => "Yatzy",
            "guide" => "För att spela klicka först starta
                , sen är det bara att klicka i dem du vill slå om",
            "message" => $_SESSION["message"],
            "dice1" => $_SESSION["dice1"]  ?? 0,
            "dice2" => $_SESSION["dice2"] ?? 0,
            "dice3" => $_SESSION["dice3"] ?? 0,
            "dice4" => $_SESSION["dice4"] ?? 0,
            "dice5" => $_SESSION["dice5"] ?? 0,
            "rolls" => $_SESSION["rolls"] ?? 0,
            "Score1" => $_SESSION["Score1"] ?? 0,
            "Score2" => $_SESSION["Score2"] ?? 0,
            "Score3" => $_SESSION["Score3"] ?? 0,
            "Score4" => $_SESSION["Score4"] ?? 0,
            "Score5" => $_SESSION["Score5"] ?? 0,
            "Score6" => $_SESSION["Score6"] ?? 0,
        ];
    }
}
