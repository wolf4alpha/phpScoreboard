<?php


namespace App\Controller;


use App\Entity\Game;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{
    /**
     * @Route("/game/new")
     */
    public function new(EntityManagerInterface $entityManager)
    {
        $game = new Game();
        $game->setName('first game'.rand(0,100));
        $game->setDescription('my first game');
        $entityManager->persist($game);
        $entityManager->flush();

        return new Response(sprintf(
            'Hello new game id is #%d, name %s',
            $game->getId(),
            $game->getName()
        ));
    }

}