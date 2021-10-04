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

namespace Ayzrix\Anvil;

use Ayzrix\Anvil\Blocks\Anvil;
use Ayzrix\Anvil\Events\Listeners\{PacketListener, PlayerListener};
use Ayzrix\Anvil\Utils\Utils;
use pocketmine\block\BlockFactory;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\SingletonTrait;

class Main extends PluginBase {
    use SingletonTrait;

    public function onLoad() {
        self::setInstance($this);
    }

    public function onEnable() {
        $this->saveDefaultConfig();
        Utils::loadConfig();
        $this->getServer()->getPluginManager()->registerEvents(new PacketListener(), $this);
        $this->getServer()->getPluginManager()->registerEvents(new PlayerListener(), $this);
        BlockFactory::registerBlock(new Anvil(), true);
    }
}

