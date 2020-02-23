<?php

namespace App\Service\Perso;

use App\Model\Guilde\Guilde;
use App\Model\Perso\Perso;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\DomCrawler\Link;

class GuildeDataPopulator
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
        $this->setGuilde();
    }

    private function setGuilde()
    {
        $result = $this->crawler->filter('html body.fr.ak-background-type-internal div.container.ak-main-container div.ak-main-content div.ak-main-page div.ak-container.ak-main-center div.row.ak-container.ak-directories div.ak-column.ak-container.col-md-4.ak-directories-left div.ak-container.ak-panel-stack.ak-glue div.ak-container.ak-panel.ak-belong-guild');
        if (!$result->count()) {
            return;
        }

        $this->perso->setGuilde((new Guilde())
            ->setId($this->getId($result))
            ->setName($this->getName($result))
            ->setLevel($this->getLevel($result))
            ->setNbMembre($this->getNbMembre($result))
        );
    }

    private function getId(Crawler $result)
    {
        /** @var Link $link */
        $link = $result->filter('div.ak-panel-content a.ak-infos-guildname')->link();
        return basename($link->getUri());
    }

    private function getName(Crawler $result)
    {
        return ucwords(strtolower($result->filter('div.ak-panel-content a.ak-infos-guildname')->text()));
    }

    private function getLevel(Crawler $result)
    {
        return (int)str_replace('Niveau ', '', $result->filter('div.ak-panel-content span.ak-infos-guildlevel')->text());
    }

    private function getNbMembre(Crawler $result)
    {
        return (int)str_replace(' membres', '', $result->filter('div.ak-panel-content span.ak-infos-guildmembers')->text());
    }
}
