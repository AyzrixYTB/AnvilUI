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

use Ayzrix\Anvil\API\InterfaceAPI;
use Ayzrix\Anvil\Utils\Utils;
use pocketmine\event\Listener;
use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\item\Durable;
use pocketmine\item\Item;
use pocketmine\network\mcpe\protocol\ModalFormResponsePacket;
use pocketmine\Player;

class PacketListener implements Listener {

    public function onDataPacketReceive(DataPacketReceiveEvent $event) {
        $packet = $event->getPacket();
        if ($packet instanceof ModalFormResponsePacket) {
            $data = json_decode($packet->formData, true);
            if ($data !== null) {
                self::handleFormResponse($event->getPlayer(), $data, $packet->formId);
            }
        }
    }

    public static function handleFormResponse(Player $player, $formData, int $formId) {
        switch ($formId) {
            case 472840:
                switch ($formData) {
                    case 0:
                        InterfaceAPI::sendAnvilRename($player);
                        break;
                    case 1:
                        InterfaceAPI::sendAnvilRepair($player);
                        break;
                }
                break;
            case 472841:
                $item = $player->getInventory()->getItemInHand();
                if (is_string($formData[0])) {
                    $text = $formData[0];
                } else $text = $formData[1];
                if ($item->getId() > 0) {
                    if (strlen($text) <= (int)Utils::getIntoConfig("name_max_long")) {
                        if (strlen($text) >= (int)Utils::getIntoConfig("name_min_long")) {
                            if ($player->getInventory()->contains(Item::get(351, 4, (int)Utils::getIntoConfig("rename_price")["lapis"]))) {
                                if ($player->getXpLevel() >= (int)Utils::getIntoConfig("rename_price")["xp"]) {
                                    $player->setXpLevel($player->getXpLevel() - (int)Utils::getIntoConfig("rename_price")["xp"]);
                                    $player->getInventory()->removeItem(Item::get(351, 4, (int)Utils::getIntoConfig("rename_price")["lapis"]));
                                    $item->setCustomName($text);
                                    $player->getInventory()->setItemInHand($item);
                                } else InterfaceAPI::sendAnvilError($player, Utils::getConfigMessage("error_not_enough_level"));
                            } else InterfaceAPI::sendAnvilError($player, Utils::getConfigMessage("error_not_enough_lapis"));
                        } else InterfaceAPI::sendAnvilError($player, Utils::getConfigMessage("error_name_too_short"));
                    } else InterfaceAPI::sendAnvilError($player, Utils::getConfigMessage("error_name_too_long"));
                } else InterfaceAPI::sendAnvilError($player, Utils::getConfigMessage("error_hand"));
                break;
            case 472842:
                switch ($formData) {
                    case 0:
                        $item = $player->getInventory()->getItemInHand();
                        if ($item instanceof Durable) {
                            if ($player->getInventory()->contains(Item::get(351, 4, (int)Utils::getIntoConfig("repair_price")["lapis"]))) {
                                if ($player->getXpLevel() >= (int)Utils::getIntoConfig("repair_price")["xp"]) {
                                    $player->setXpLevel($player->getXpLevel() - (int)Utils::getIntoConfig("repair_price")["xp"]);
                                    $player->getInventory()->removeItem(Item::get(351, 4, (int)Utils::getIntoConfig("repair_price")["lapis"]));
                                    $item->setDamage(0);
                                    if ($item->getNamedTag()->offsetExists("Durabilité")) $item->getNamedTag()->setString("Durabilité", $item->getMaxDurability());
                                    $player->getInventory()->setItemInHand($item);
                                    $player->sendMessage(Utils::getConfigMessage("repair_success"));
                                } else InterfaceAPI::sendAnvilError($player, Utils::getConfigMessage("error_not_enough_level"));
                            } else InterfaceAPI::sendAnvilError($player, Utils::getConfigMessage("error_not_enough_lapis"));
                        } else InterfaceAPI::sendAnvilError($player, Utils::getConfigMessage("error_unrepairable"));
                        break;
                    case 1:
                        InterfaceAPI::sendAnvilMenu($player);
                        break;
                }
                break;
            case 472843:
                InterfaceAPI::sendAnvilMenu($player);
                break;
        }
    }
}