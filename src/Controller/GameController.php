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

    /**
     * @param EntityManagerInterface $entityManager
     * @Route("/game/list")
     */
    public function listGames(EntityManagerInterface $entityManager){
        $repository = $entityManager->getRepository(Game::class);
        $games = $repository->findAll();
        $data = [
            'games' => $games
        ];
        return  $this->render('game_list.html.twig',$data);
    }

    /**
     * @Route("/game/show/{slug}")
     */
    public function show($slug, EntityManagerInterface $entityManager){

        $repository = $entityManager->getRepository(Game::class);
        $game = $repository->findOneBy(['name' => $slug]);
        if(!$game){
            throw $this->createNotFoundException(sprintf('no game found for name: %s',$slug));
        }
        $data = [
            'game' => $game
        ];
        return $this->render('game_show.html.twig',$data);
    }

}