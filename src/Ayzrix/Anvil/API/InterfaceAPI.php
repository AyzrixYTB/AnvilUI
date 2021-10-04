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

namespace Ayzrix\Anvil\API;

use Ayzrix\Anvil\Utils\Utils;
use pocketmine\Player;

class InterfaceAPI {

    public static function sendAnvilMenu(Player $player) {
        $ui = new SimpleFormAPI();
        $ui->setId(472840);
        $ui->setTitle(Utils::getConfigMessage("ui_title"));
        $ui->setContent(Utils::getConfigMessage("menu_description"));
        $ui->setButton(Utils::getConfigMessage("rename_button"));
        $ui->setButton(Utils::getConfigMessage("repair_button"));
        $ui->send($player);
    }

    public static function sendAnvilRename(Player $player) {
        $ui = new CustomFormAPI();
        $ui->setId(472841);
        $item = $player->getInventory()->getItemInHand();
        $ui->setTitle(Utils::getConfigMessage("ui_title"));
        $ui->setLabel(Utils::getConfigMessage("rename_description"));
        $name = $item->getVanillaName();
        if ($item->hasCustomName()) $name = $item->getCustomName();
        $ui->setInput(Utils::getConfigMessage("rename_input_name"), $name);
        $ui->send($player);
    }

    public static function sendAnvilRepair(Player $player) {
        $ui = new SimpleFormAPI();
        $ui->setId(472842);
        $ui->setTitle(Utils::getConfigMessage("ui_title"));
        $ui->setContent(Utils::getConfigMessage("repair_description"));
        $ui->setButton(Utils::getConfigMessage("yes_button"));
        $ui->setButton(Utils::getConfigMessage("no_button"));
        $ui->send($player);
    }

    public static function sendAnvilError(Player $player, string $error) {
        $ui = new SimpleFormAPI();
        $ui->setId(472843);
        $ui->setTitle(Utils::getConfigMessage("ui_title"));
        $ui->setContent($error);
        $ui->setButton(Utils::getConfigMessage("back_button"));
        $ui->send($player);
    }
}