<?php

namespace App\Service\Perso;

use App\Model\Perso\Metier;
use Symfony\Component\DomCrawler\Crawler;

class MetierObjectProvider
{
    public function getObjectMetier(Crawler $node)
    {
        return (new Metier())
            ->setName($this->getMetierName($node))
            ->setLevel($this->getMetierLevel($node))
            ;
    }

    private function getMetierName(Crawler $node)
    {
        return $node->filter('div.ak-main div.ak-main-content div.ak-content div.ak-title')->text();
    }

    private function getMetierLevel(Crawler $node)
    {
        $textLevel = $node->filter('div.ak-main div.ak-main-content div.ak-content div.ak-text')->text();
        preg_match_all('/\d+/', $textLevel, $matches);
        return (int)$matches[0][0];
    }
}
