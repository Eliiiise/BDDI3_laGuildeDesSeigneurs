<?php

namespace App\Service;

use DateTime;
use App\Entity\Character;
use Doctrine\ORM\EntityManagerInterface;

class CharacterService implements CharacterServiceInterface {

    private $em;

    public function __construct(EntityManagerInterface $em){
        $this->em = $em;
    }

    public function create()
    {
        $character = new Character();
        $character
            ->setKind('Dame')
            ->setName('Athelleen')
            ->setSurname('Guerrière des flammes')
            ->setCaste('Guerrier')
            ->setKnowledge('Cartographie')
            ->setIntelligence(90)
            ->setLife(15)
            ->setCreation(new \DateTime())
            ->setIdentifier(hash('sha1', uniqid()))
        ;

        //tell Doctrine you want to save the Character (no queries yet)
        $this->em->persist($character);

        //actually executes the queries (i.e. the INSERT query)
        $this->em->flush();

        return $character;
    }
}
