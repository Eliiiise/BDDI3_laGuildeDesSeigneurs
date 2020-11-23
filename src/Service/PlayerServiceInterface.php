<?php

namespace App\Service;
use App\Entity\Player;

interface PlayerServiceInterface {

    /**
     * Create the player
     */

    public function create(String $data);

    /**
     * Display all the players
     */
    public function getAll();

    /**
     * Modify a player
     */

    public function modify(Player $player, String $data);

    /**
     * Checks if the netity has been well filled
     */

    public function isEntityFilled(Player $player);

    /**
     * Submits the date to hydrate the object
     */

    public function submit(Player $player, $formName, $data);


    /**
     * Delete a player
     */

    public function delete(Player $player);

}
