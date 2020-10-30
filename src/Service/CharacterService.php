<?php

namespace App\Service;

use DateTime;
use App\Entity\Character;

class CharacterService implements CharacterServiceInterface
{
    /**
     * {@inheritdoc}
     */
    public function create() {
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
        ;

        return new $character;
    }
}

