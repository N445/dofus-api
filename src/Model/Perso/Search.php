<?php

namespace App\Model\Perso;

class Search
{
    /**
     * @var string
     */
    private $classe;

    /**
     * @var string
     */
    private $server;

    /**
     * @var string
     */
    private $name;

    /**
     * @return string
     */
    public function getClasse(): string
    {
        return $this->classe;
    }

    /**
     * @param string $classe
     * @return Search
     */
    public function setClasse(string $classe): Search
    {
        $this->classe = $classe;
        return $this;
    }

    /**
     * @return string
     */
    public function getServer(): string
    {
        return $this->server;
    }

    /**
     * @param string $server
     * @return Search
     */
    public function setServer(string $server): Search
    {
        $this->server = $server;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Search
     */
    public function setName(string $name): Search
    {
        $this->name = $name;
        return $this;
    }


}
