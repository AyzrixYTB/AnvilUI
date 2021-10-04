<?php

/***
 *                          _ _ _    _ _____
 *         /\              (_) | |  | |_   _|
 *        /  \   _ ____   ___| | |  | | | |
 *       / /\ \ | '_ \ \ / / | | |  | | | |
 *      / ____ \| | | \ V /| | | |__| |_| |_
 *     /_/    \_\_| |_|\_/ |_|_|\____/|_____|
 *
 *
 */

namespace Ayzrix\Anvil\Events\Listeners;

use Ayzrix\Anvil\Blocks\Anvil;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\Listener;

class PlayerListener implements Listener {

    public function onBlockPlace(BlockPlaceEvent $event) {
        if ($event->getBlockAgainst() instanceof Anvil) {
            $event->setCancelled(true);
        }
    }
}