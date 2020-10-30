<?php

namespace App\Service;

use DateTime;
use App\Entity\Character;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CharacterRepository;

class CharacterService implements CharacterServiceInterface
{
    private $em;
    private $characterRepository;

    public function __construct(
        CharacterRepository $characterRepository,
        EntityManagerInterface $em
    ){
        $this->characterRepository = $characterRepository;
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

    /**
     * {@inheritdoc}
     */
    public function getAll()
    {
        $charactersFinal = array();
        $characters = $this->characterRepository->findAll();
        foreach ($characters as $character) {
            $charactersFinal[] = $character->toArray();
        }
        return $charactersFinal;
    }

    /**
     * {@inheritdoc}
     */
    public function modify(Character $character)
    {
        $character
            ->setKind('Dame')
            ->setName('Athelleen')
            ->setSurname('Guerrière des flammes')
            ->setCaste('Guerrier')
            ->setKnowledge('Cartographie')
            ->setIntelligence(90)
            ->setLife(15)
            ->setCreation(new \DateTime())
        ;

        $this->em->persist($character);
        $this->em->flush();

        return $character;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(Character $character)
    {
        $this->em->remove($character);
        $this->em->flush();

        return true;
    }

}
