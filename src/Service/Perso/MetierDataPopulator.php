<?php

namespace App\Service\Perso;

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

    /**
     * @var MetierObjectProvider
     */
    private $metierObjectProvider;

    /**
     * MetierDataPopulator constructor.
     * @param MetierObjectProvider $metierObjectProvider
     */
    public function __construct(MetierObjectProvider $metierObjectProvider)
    {
        $this->metierObjectProvider = $metierObjectProvider;
    }

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
            return $this->metierObjectProvider->getObjectMetier($node);
        }));
    }
}
