<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use App\Yatzy\YatzyGame;

class YatzyController extends AbstractController
{
    
    public function Yatzy(): Response
    {
        $game = new YatzyGame();

        return $this->render('yatzy.html.twig', $game->getData());
    }
}
