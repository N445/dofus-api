<?php

namespace App\Utils\Guilde;

use App\Model\Guilde\Guilde;

class PageCalculator
{
    const NB_PER_PAGE = 25;

    /**
     * @param Guilde $guilde
     * @return int
     */
    public static function getNbPage(Guilde $guilde)
    {
        return (int)ceil($guilde->getNbMembre() / self::NB_PER_PAGE);
    }
}
