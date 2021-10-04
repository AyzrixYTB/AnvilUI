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

namespace Ayzrix\Anvil\Blocks;

use Ayzrix\Anvil\API\InterfaceAPI;
use pocketmine\block\Anvil as PMAnvil;
use pocketmine\item\Item;
use pocketmine\Player;

class Anvil extends PMAnvil {

    protected $id = self::ANVIL;
    private $interact = [];

    public function __construct(int $meta = 0){
        parent::__construct($meta);
    }

    public function onActivate(Item $item, Player $player = null): bool {
        if ($player === null) return false;
        if (!isset($this->interact[$player->getName()])) $this->interact[$player->getName()] = 1;
        if (round($this->interact[$player->getName()], 1) + 1 <= round(microtime(true), 1)) {
            $this->interact[$player->getName()] = microtime(true);
            if (!$player->isSneaking()) {
                InterfaceAPI::sendAnvilMenu($player);
                return true;
            }
        }
        return false;
    }

    public function getBlastResistance(): float{
        return 1;
    }
}