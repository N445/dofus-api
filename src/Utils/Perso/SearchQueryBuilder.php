<?php

namespace App\Utils\Perso;

use App\Model\Perso\Search;

class SearchQueryBuilder
{
    /**
     * @var array
     */
    private $query = [];

    /**
     * @var Search
     */
    private $search;


    /**
     * @param Search $search
     * @return array
     */
    public function getQuery(Search $search)
    {
        $this->search = $search;
        $this->setClasse();
        $this->setServer();
        $this->setName();
        $this->setLevelMin();
        $this->setLevelMax();
        $this->setGuilde();
        $this->setSexe();
        return $this->query;
    }

    private function setClasse()
    {
        if (!$this->search->getClasse()) {
            return;
        }
        foreach ($this->search->getClasse() as $key => $classe) {
            $this->query[sprintf('character_breed_id[%d]', $key)] = $classe;
        }
    }

    private function setServer()
    {
        if (!$this->search->getServer()) {
            return;
        }
        foreach ($this->search->getServer() as $key => $server) {
            $this->query[sprintf('character_homeserv[%d]', $key)] = $server;
        }
    }

    private function setName()
    {
        if (!$this->search->getName()) {
            return;
        }
        $this->query['text'] = $this->search->getName();
    }

    private function setLevelMin()
    {
        if (!$this->search->getLevelMin()) {
            return;
        }
        $this->query['character_level_min'] = $this->search->getLevelMin();
    }

    private function setLevelMax()
    {
        if (!$this->search->getLevelMax()) {
            return;
        }
        $this->query['character_level_max'] = $this->search->getLevelMax();
    }

    private function setGuilde()
    {
        if (null === $this->search->getHasGuilde()) {
            return;
        }
        $this->query['guild_id[]'] = $this->getQueryGuildeText();
    }

    private function getQueryGuildeText()
    {
        if($this->search->getHasGuilde()){
            return 'guild_yes';
        }
        return 'guild_no';
    }

    private function setSexe()
    {
        if (!$this->search->getSexe()) {
            return;
        }
        $this->query['character_sex[]'] = $this->search->getSexe();
    }


}