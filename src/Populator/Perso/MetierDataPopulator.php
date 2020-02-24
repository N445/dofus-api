<?php

namespace App\Populator\Perso;

use App\Model\Perso\Metier;
use App\Model\Perso\Perso;
use Symfony\Component\DomCrawler\Crawler;

class MetierDataPopulator
{
    /**
     * @var Perso
     */
    private $perso;

    /**
     * @var Crawler
     */
    private $crawler;

    public function populate(Perso &$perso, Crawler $crawler)
    {
        $this->perso   = $perso;
        $this->crawler = $crawler;
        $this->setMetiers();
    }

    private function setMetiers()
    {
        $result = $this->crawler->filter('html body.fr.ak-background-type-internal div.container.ak-main-container div.ak-main-content div.ak-main-page div.ak-container.ak-main-center div.row.ak-container.ak-directories div.ak-column.ak-container.col-md-4.ak-directories-left div.ak-container.ak-panel-stack.ak-glue div.ak-container.ak-panel.ak-infos-jobs div.ak-panel-content div.ak-container.ak-content-list div.ak-lists-paginable div.ak-list-element');

        $this->perso->setMetiers($result->each(function (Crawler $node, $i) {
            return $this->getObjectMetier($node);
        }));
    }

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
