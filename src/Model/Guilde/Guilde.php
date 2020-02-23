<?php

namespace App\Model\Guilde;

class Guilde
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var integer
     */
    private $level;

    /**
     * @var integer
     */
    private $nbMembre;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return Guilde
     */
    public function setId(string $id): Guilde
    {
        $this->id = $id;
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
     * @return Guilde
     */
    public function setName(string $name): Guilde
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return int
     */
    public function getLevel(): int
    {
        return $this->level;
    }

    /**
     * @param int $level
     * @return Guilde
     */
    public function setLevel(int $level): Guilde
    {
        $this->level = $level;
        return $this;
    }

    /**
     * @return int
     */
    public function getNbMembre(): int
    {
        return $this->nbMembre;
    }

    /**
     * @param int $nbMembre
     * @return Guilde
     */
    public function setNbMembre(int $nbMembre): Guilde
    {
        $this->nbMembre = $nbMembre;
        return $this;
    }
}
