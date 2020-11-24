<?php

namespace App\Event;

use App\Event\PlayerEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class PlayerListener implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return array(
          PlayerEvent::PLAYER_MODIFIED => 'playerModified',
        );
    }

    public function playerModified($event)
    {
        $player = $event->getPlayer();

        $miran = $player->getMirian(250);
        $player->setMirian($miran - 10);

    }
}
