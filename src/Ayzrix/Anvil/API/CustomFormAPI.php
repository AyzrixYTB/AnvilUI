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

class CustomFormAPI {

    /** @var int */
    protected $id;
    /** @var array */
    protected $formData = [];

    public function __construct(){
        $this->formData["type"] = "custom_form";
        $this->formData["content"] = [];
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

    public function setLabel(string $label) {
        $this->formData["content"][] = [
            "type" => "label",
            "text" => $label,
        ];
    }

    public function setInput(string $input, string $placeholder = '', string $default = null){
        $this->formData["content"][] = [
            "type" => "input",
            "text" => $input,
            "placeholder" => $placeholder,
            "default " => $default !== null ? $default : ''
        ];
    }
}