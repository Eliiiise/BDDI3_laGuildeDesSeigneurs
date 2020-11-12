<?php

namespace App\Service;

use DateTime;
use App\Entity\Player;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\PlayerRepository;

class PlayerService implements PlayerServiceInterface
{
    private $em;
    private $playerRepository;

    public function __construct(
        PlayerRepository $playerRepository,
        EntityManagerInterface $em
    ){
        $this->playerRepository = $playerRepository;
        $this->em = $em;
    }

    public function create()
    {
        $player = new Player();
        $player
            ->setFirstname('Elise')
            ->setLastname('Valloire')
            ->setEmail('balvalloire@gmail.com')
            ->setMirian(100)
            ->setPassword('aeR26x')
            ->setCreation(new \DateTime())
            ->setIdentifier(hash('sha1', uniqid()))
            ->setModification(new \DateTime())
        ;

        //tell Doctrine you want to save the Player (no queries yet)
        $this->em->persist($player);

        //actually executes the queries (i.e. the INSERT query)
        $this->em->flush();

        return $player;
    }

    /**
     * {@inheritdoc}
     */
    public function getAll()
    {
        $playersFinal = array();
        $players = $this->playerRepository->findAll();
        foreach ($players as $player) {
            $playersFinal[] = $player->toArray();
        }
        return $playersFinal;
    }

    /**
     * {@inheritdoc}
     */
    public function modify(Player $player)
    {
        $player
            ->setFirstname('Elise')
            ->setLastname('Valloire')
            ->setEmail('balvalloire@gmail.com')
            ->setMirian(100)
            ->setPassword('aeR26x')
            ->setModification(new \DateTime())
        ;

        $this->em->persist($player);
        $this->em->flush();

        return $player;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(Player $player)
    {
        $this->em->remove($player);
        $this->em->flush();

        return true;
    }

}
