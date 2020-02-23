<?php

namespace App\Service\Perso;

use App\Model\Perso\Perso;
use Symfony\Component\DomCrawler\Crawler;

class PrimaryDataPopulator
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
        $this->setName();
        $this->setLevel();
        $this->setClasse();
        $this->setGrade();
        $this->setServer();
        $this->setSuccessPoints();
    }

    private function setName()
    {
        $result = $this->crawler->filter('html body.fr.ak-background-type-internal div.container.ak-main-container div.ak-main-content div.ak-main-page div.ak-container.ak-main-center div.ak-title-container.ak-backlink h1.ak-return-link');
        $this->perso->setName($result->text());
    }

    private function setLevel()
    {
        $result = $this->crawler->filter('html body.fr.ak-background-type-internal div.container.ak-main-container div.ak-main-content div.ak-main-page div.ak-container.ak-main-center div.ak-container.ak-panel.ak-nocontentpadding div.ak-panel-content div.ak-directories-header div.ak-directories-main-infos div.ak-directories-property span.ak-directories-level');

        if ($result->filter('.ak-omega-level')->count()) {
            $level = (int)str_replace('Niveau Omega ', '', $result->text());
            $this->perso->setIsOmega(true)
                        ->setLevel(200 + $level)
            ;
            return;
        }
        $level = (int)str_replace('Niveau ', '', $result->text());
        $this->perso->setIsOmega(false)
                    ->setLevel($level)
        ;
    }

    private function setClasse()
    {
        $result = $this->crawler->filter('html body.fr.ak-background-type-internal div.container.ak-main-container div.ak-main-content div.ak-main-page div.ak-container.ak-main-center div.ak-container.ak-panel.ak-nocontentpadding div.ak-panel-content div.ak-directories-header div.ak-directories-main-infos div.ak-directories-property span.ak-directories-breed');
        $this->perso->setClasse($result->text());
    }

    private function setGrade()
    {
        $result = $this->crawler->filter('html body.fr.ak-background-type-internal div.container.ak-main-container div.ak-main-content div.ak-main-page div.ak-container.ak-main-center div.ak-container.ak-panel.ak-nocontentpadding div.ak-panel-content div.ak-directories-header div.ak-directories-main-infos div.ak-directories-property.ak-directories-property-grade span.ak-directories-grade');
        if (!$result->count()) {
            return;
        }
        $this->perso->setGrade($result->text());
    }

    private function setServer()
    {
        $result = $this->crawler->filter('html body.fr.ak-background-type-internal div.container.ak-main-container div.ak-main-content div.ak-main-page div.ak-container.ak-main-center div.ak-container.ak-panel.ak-nocontentpadding div.ak-panel-content div.ak-directories-header div.ak-directories-main-infos div.ak-directories-property.ak-directories-property-server span.server span.ak-directories-server-name');
        $this->perso->setServer($result->text());
    }

    private function setSuccessPoints()
    {
        $result = $this->crawler->filter('html body.fr.ak-background-type-internal div.container.ak-main-container div.ak-main-content div.ak-main-page div.ak-container.ak-main-center div.row.ak-container.ak-directories div.ak-column.ak-container.col-md-4.ak-directories-left div.ak-container.ak-panel-stack.ak-glue div.ak-container.ak-panel.ak-infos-success div.ak-panel-content div.ak-block-points div.ak-character-score div.ak-character-score-layer a span.ak-score-text');
        $this->perso->setSuccessPoints((int)$result->text());
    }
}
