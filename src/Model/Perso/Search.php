<?php

namespace App\Model\Perso;

class Search
{
    /**
     * @var array|null
     */
    private $classe;

    /**
     * @var array|null
     */
    private $server;

    /**
     * @var string|null
     */
    private $name;

    /**
     * @var integer|null
     */
    private $levelMin = 20;

    /**
     * @var integer|null
     */
    private $levelMax = 999999;

    /**
     * @var boolean|null
     */
    private $hasGuilde;

    /**
     * @var integer|null
     */
    private $sexe;

    /**
     * @var integer|null
     */
    private $maxResults = 5;

    /**
     * @return array|null
     */
    public function getClasse(): ?array
    {
        return $this->classe;
    }

    /**
     * @param array|null $classe
     * @return Search
     */
    public function setClasse(?array $classe): Search
    {
        $this->classe = $classe;
        return $this;
    }

    /**
     * @param string|null $classe
     * @return Search
     */
    public function addClasse(?string $classe): Search
    {
        $this->classe[] = $classe;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getServer(): ?array
    {
        return $this->server;
    }

    /**
     * @param array|null $server
     * @return Search
     */
    public function setServer(?array $server): Search
    {
        $this->server = $server;
        return $this;
    }

    /**
     * @param string|null $server
     * @return Search
     */
    public function addServer(?string $server): Search
    {
        $this->server[] = $server;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return Search
     */
    public function setName(?string $name): Search
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getLevelMin(): ?int
    {
        return $this->levelMin;
    }

    /**
     * @param int|null $levelMin
     * @return Search
     */
    public function setLevelMin(?int $levelMin): Search
    {
        $this->levelMin = $levelMin;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getLevelMax(): ?int
    {
        return $this->levelMax;
    }

    /**
     * @param int|null $levelMax
     * @return Search
     */
    public function setLevelMax(?int $levelMax): Search
    {
        $this->levelMax = $levelMax;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function getHasGuilde(): ?bool
    {
        return $this->hasGuilde;
    }

    /**
     * @param bool|null $hasGuilde
     * @return Search
     */
    public function setHasGuilde(?bool $hasGuilde): Search
    {
        $this->hasGuilde = $hasGuilde;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getSexe(): ?int
    {
        return $this->sexe;
    }

    /**
     * @param int|null $sexe
     * @return Search
     */
    public function setSexe(?int $sexe): Search
    {
        $this->sexe = $sexe;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getMaxResults(): ?int
    {
        return $this->maxResults;
    }

    /**
     * @param int|null $maxResults
     * @return Search
     */
    public function setMaxResults(?int $maxResults): Search
    {
        $this->maxResults = $maxResults;
        return $this;
    }
}
