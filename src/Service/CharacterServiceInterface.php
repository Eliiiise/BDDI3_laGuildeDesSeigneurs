<?php

namespace App\Service;

use App\Entity\Character;

interface CharacterServiceInterface
{
    /**
     * Creates the character
     */
    public function create(string $data);

    /**
     * Gets all the characters
     */
    public function getAll();

    /**
     * Modifies the characters
     */
    public function modify(Character $character, String $data);

    /**
     * Delete the characters
     */
    public function delete(Character $character);

    /**
     * Checks if the entity has been well filled
     */
    public function isEntityFilled(Character $character);

    /**
     * Submits the data to hydrate the object
     */
    public function submit(Character $character, $formName, $data);

    /**
     * Creates the character from html form
     */
    public function createFromHtml(Character $character);

    /**
     * Creates the character from html form
     */
    public function modifyFromHtml(Character $character);
}
