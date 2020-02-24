<?php

namespace App\Utils\Perso;

class ClasseProvider
{
    public static function getClasses()
    {
        return [
            1  => "Le bouclier Féca",
            2  => "Le fouet d'Osamodas",
            3  => "Les doigts d'Enutrof",
            4  => "L'ombre de Sram",
            5  => "Le sablier de Xélor",
            6  => "La piéce d'Ecaflip",
            7  => "Les mains d'Eniripsa",
            8  => "Le coeur d'Iop",
            9  => "L'étendue de Crâ",
            10 => "Le soulier de Sadida",
            11 => "Le sang de Sacrieur",
            12 => "La chopine de Pandawa",
            13 => "La ruse du Roublard",
            14 => "Le masque du Zobal",
            15 => "La vapeur du Steamer",
            16 => "Le portail Eliotrope",
            17 => "La rune de l'Huppermage",
            18 => "La rage d'Ouginak",
        ];
    }

    public static function getIdFromText($key)
    {
        $classes = array_flip(self::getClasses());
        if (!array_key_exists($key, $classes)) {
            return false;
        }
        return $classes[$key];
    }
}
