<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use App\Dice\GameOf21;

class DiceController extends AbstractController
{
    
    public function GameOf21(): Response
    {
        //$session = new Session();
        //$session->start();
        //$session->set('test', 'bajs');

        $game = new GameOf21();

        return $this->render('game21.html.twig', $game->getData());
    }
}
