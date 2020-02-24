<?php

namespace App\Utils\Perso;

class ServerProvider
{
    public static function getServers()
    {
        return [
            36  => "Agride",
            22  => "Oto-Mustam",
            205 => "Meriana",
            206 => "Pandore",
            203 => "Rubilax",
            222 => "Ilyzaelle",
            50  => "Ombre",
            204 => "Atcham",
            201 => "Echo",
            207 => "Ush",
            208 => "Julith",
            209 => "Nidas",
            212 => "Brumen",
            211 => "Furye",
            210 => "Merkator",
            202 => "Crocabulia",
            232 => "Temporis (2eme édition) ",
            238 => "Temporis III",
        ];
    }

    public static function getIdFromText($key)
    {
        $classes = array_flip(self::getServers());
        if (!array_key_exists($key, $classes)) {
            return false;
        }
        return $classes[$key];
    }
}
