<?php

namespace App\Populator\Guilde;

use App\Model\Guilde\Guilde;
use Symfony\Component\DomCrawler\Crawler;

class PrimaryDataPopulator
{
    /**
     * @var Guilde
     */
    private $guilde;

    /**
     * @var Crawler
     */
    private $crawler;

    public function populate(Guilde &$guilde, Crawler $crawler)
    {
        $this->guilde  = $guilde;
        $this->crawler = $crawler;
        $this->setName();
        $this->setLevel();
        $this->setNbMembre();
        $this->setCreatedAt();
    }

    private function setName()
    {
        $this->guilde->setName($this->crawler->filter('html body.fr.ak-background-type-internal div.container.ak-main-container div.ak-main-content div.ak-main-page div.ak-container.ak-main-center div.ak-title-container.ak-backlink h1.ak-return-link')->text());
    }

    private function setLevel()
    {
        $this->guilde->setLevel((int)str_replace('Niveau ', '', $this->crawler->filter('html body.fr.ak-background-type-internal div.container.ak-main-container div.ak-main-content div.ak-main-page div.ak-container.ak-main-center div.ak-container.ak-panel.ak-directories-header-guild.ak-nocontentpadding div.ak-panel-content div.ak-directories-header div.ak-directories-main-infos div.ak-directories-property span.ak-directories-level')->text()));
    }

    private function setNbMembre()
    {
        $this->guilde->setNbMembre((int)str_replace(' membres', '', $this->crawler->filter('html body.fr.ak-background-type-internal div.container.ak-main-container div.ak-main-content div.ak-main-page div.ak-container.ak-main-center div.ak-container.ak-panel.ak-directories-header-guild.ak-nocontentpadding div.ak-panel-content div.ak-directories-header div.ak-directories-main-infos div.ak-directories-property span.ak-directories-breed')->text()));
    }

    private function setCreatedAt()
    {
        $dateString = $this->crawler->filter('html body.fr.ak-background-type-internal div.container.ak-main-container div.ak-main-content div.ak-main-page div.ak-container.ak-main-center div.ak-container.ak-panel.ak-directories-header-guild.ak-nocontentpadding div.ak-panel-content div.ak-directories-header div.ak-directories-main-infos div.ak-directories-property.ak-directories-property-creation-date span.ak-directories-creation-date')->text();
        $dateString = str_replace('Création : Depuis le ', '', $dateString);
        $this->guilde->setCreatedAt(\DateTime::createFromFormat('d/m/Y', $dateString));
    }
}
