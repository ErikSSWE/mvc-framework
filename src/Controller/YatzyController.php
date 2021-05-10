<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use App\Yatzy\YatzyGame;
use App\Entity\Highscore;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;


class YatzyController extends AbstractController
{
    /**
     * @Route("/yatzy", name="yatzy")
     */
    public function Yatzy(): Response
    {
        $repository = $this->getDoctrine()->getRepository(Highscore::class);
        $highscores = $repository->topTenScore();
        $game = new YatzyGame($repository);
        if ($game->checkHighScore() == true && $game->checker == true) {
            return $this->redirectToRoute('new', ['score' => $game->getHighscore()]);
        }
        return $this->render('yatzy.html.twig', $game->getData());
    }
}
