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

use pocketmine\network\mcpe\protocol\ModalFormRequestPacket;
use pocketmine\Player;

class SimpleFormAPI {

    /** @var string */
    public static $cache = [];
    /** @var int */
    protected $id;
    /** @var array */
    protected $formData = [];

    public function __construct(){
        $this->formData["type"] = "form";
        $this->formData["content"] = "";
        $this->formData["buttons"] = [];
    }

    public function setId(int $id){
        $this->id = $id;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getEncodedFormData(): string{
        return json_encode($this->formData);
    }

    public function send(Player $player) {
        $data = $this->getEncodedFormData();
        $pk = new ModalFormRequestPacket();
        $pk->formData = $data;
        $pk->formId = $this->id;
        $player->dataPacket($pk);
    }

    public function setTitle(string $title) {
        $this->formData["title"] = $title;
    }

    public function setContent(string $text) {
        $this->formData["content"] = $text;
    }

    public function setButton(string $text, int $imageType = -1, string $imagePath = "") : void {
        $content = ["text" => $text];
        if ($imageType !== -1) {
            $content["image"]["type"] = $imageType === 0 ? "path" : "url";
            $content["image"]["data"] = $imagePath;
        }
        $this->formData['buttons'][] = $content;
    }
}