<?php

namespace App\Populator\Guilde;

use App\Model\Guilde\Guilde;
use App\Model\Guilde\Members;
use Symfony\Component\DomCrawler\Crawler;

class MembersDataPopulator
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
        $this->setMembers();
    }

    private function setMembers()
    {
        foreach ($this->getMembers() as $member){
            $this->guilde->addMember($member);
        }
    }

    private function getMembers(){
        $result = $this->crawler->filter('html body.fr.ak-background-type-internal div.container.ak-main-container div.ak-main-content div.ak-main-page div.ak-container.ak-main-center div.ak-container.ak-panel.ak-guilds div.ak-panel-content table.ak-container.ak-table.ak-responsivetable tbody tr.tr_class');
        return $result->each(function (Crawler $node, $i) {
            return $this->getObjectMember($node);
        });
    }

    private function getObjectMember(Crawler $node)
    {
        return (new Members())
            ->setName($node->filter('td')->eq(0)->text())
            ->setClasse($node->filter('td')->eq(1)->text())
            ->setLevel((int)$node->filter('td')->eq(2)->text())
            ->setIsOmega((int)$node->filter('td')->eq(2)->text() > 200)
            ->setRang($node->filter('td')->eq(3)->text())
            ;
    }
}
