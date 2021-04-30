<?php

declare(strict_types=1);

namespace App\Dice;

use App\Dice\DiceHand;
use Symfony\Component\HttpFoundation\Session\Session;

class GameOf21
{
    protected $diceHand = null;

    protected $session = null;

    protected $playerScore = 0;

    protected array $data = [
        "header" => "Game21 page",
        "message" => "Test, player!",
        "playerScore" => 0,
    ];

    public function __construct()
    {
        $this->session = new Session();
        //echo "test:::" . $this->session->get('test');
        $this->session->set('test', +1);
        //echo "test:::" . $this->session->get('test');



        if (empty($this->session->get('playerGames'))) {
            $this->session->set('playerGames', 0);
        }

        if (empty($this->session->get('howManySides'))) {
            $this->session->set('howManySides', 6);
        }

        if (empty($this->session->get('howManyDices'))) {
            $this->session->set('howManyDices', 2);
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
                $this->session->set('computerGames', 0);
                $this->session->set('playerGames', 0);
                $this->initGame();
                break;
            case 'computer':
                $this->continueGame();
                while ($this->session->get('computerScore') < 21 && $this->session->get('computerScore') < $this->session->get('playerScore')) {
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
        if ($this->session->get('playerScore') > 21) {

            $score = 1;
            $this->addValueToSessionVar('computerGames', $score);
        } elseif ($this->session->get('computerScore') <= 21 && $this->session->get('computerScore') > $this->session->get('playerScore')) {
            //echo "<h2> Dator Vinner! </h2>";
            $score = 1;
            $this->addValueToSessionVar('computerGames', $score);

        } elseif ($this->session->get('playerScore') <= 21 && $this->session->get('computerScore') < $this->session->get('playerScore')) {
            //echo "<h2> Spelare Vinner! </h2>";
            $score = 1;
            $this->addValueToSessionVar('playerScore', $score);

        } elseif ($this->session->get('computerScore') == $this->session->get('playerScore') && $this->session->get('playerScore') <= 21) {
            //echo "<h2> Lika, Dator Vinner! </h2>";
            $score = 1;
            $this->addValueToSessionVar('computerGames', $score);

        } elseif ($this->session->get('computerScore') > 21 && $this->session->get('playerScore') <= 21) {
            //echo "<h2> Dator Full!, Spelare Vinner! </h2>";
            $score = 1;
            $this->addValueToSessionVar('playerGames', $score);
        }
    }

    public function initGame()
    {
        $this->session->set('playerScore', 0);
        $this->session->set('computerScore', 0);
        $this->session->set('howManyDices', (int)$_POST["howManyDices"] ?? 2);
        $this->session->set('howManySides', (int)$_POST["howManySides"] ?? 6);
        $this->diceHand = new DiceHand($this->session->get('howManyDices'), $this->session->get('howManySides'));
    }

    public function continueGame()
    {
        $this->diceHand = new DiceHand(
            (int)$this->session->get('howManyDices') ?? 2,
            (int)$this->session->get('howManySides') ?? 6
        );
    }

    public function playerRoll()
    {
        $roll = $this->diceHand->rollDices();
        $this->addValueToSessionVar('playerScore', $roll);
    }

    public function addValueToSessionVar($name, $value)
    {
        $val = $this->session->get($name);
        $newVal = $val += $value;
        $newVal = $this->session->set($name, $newVal);
    }

    public function computerRoll()
    {
        $roll = $this->diceHand->rollDices();
        $this->addValueToSessionVar('computerScore', $roll);
    }


    public function getData()
    {
        return [
            "header" => "Game21 page",
            "message" => "Test, player!",
            "howManyDices" => $this->session->get('howManyDices') ?? 1,
            "howManySides" => $this->session->get('howManySides') ?? 6,
            "playerScore" => $this->session->get('playerScore') ?? 0,
            "computerScore" => $this->session->get('computerScore') ?? 0,
            "playerGames" => $this->session->get('playerGames') ?? 0,
            "computerGames" => $this->session->get('computerGames') ?? 0,
        ];
    }
}
