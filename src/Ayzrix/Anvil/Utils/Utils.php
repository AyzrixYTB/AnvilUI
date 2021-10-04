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

namespace Ayzrix\Anvil\Utils;

use Ayzrix\Anvil\Main;

class Utils {

    private static $config = [];

    public static function getPrefix(): string {
        return self::getIntoConfig("prefix");
    }

    public static function getConfigMessage(string $text, array $args = array()): string {
        $message = self::getIntoConfig($text);
        if (!empty($args)) {
            foreach ($args as $arg) {
                $message = preg_replace("/[%]/", $arg, $message, 1);
            }
        }
        return str_replace('{prefix}', self::getPrefix(), $message);
    }

    public static function loadConfig() {
        self::$config = Main::getInstance()->getConfig()->getAll();
    }

    public static function getIntoConfig(string $value) {
        return self::$config[$value];
    }
}