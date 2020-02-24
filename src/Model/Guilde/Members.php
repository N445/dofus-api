<?php

namespace App\Model\Guilde;

class Members
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $classe;

    /**
     * @var integer
     */
    private $level;

    /**
     * @var bool
     */
    private $isOmega = false;

    /**
     * @var string
     */
    private $rang;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Members
     */
    public function setName(string $name): Members
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getClasse(): string
    {
        return $this->classe;
    }

    /**
     * @param string $classe
     * @return Members
     */
    public function setClasse(string $classe): Members
    {
        $this->classe = $classe;
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
     * @return Members
     */
    public function setLevel(int $level): Members
    {
        $this->level = $level;
        return $this;
    }

    /**
     * @return bool
     */
    public function isOmega(): bool
    {
        return $this->isOmega;
    }

    /**
     * @param bool $isOmega
     * @return Members
     */
    public function setIsOmega(bool $isOmega): Members
    {
        $this->isOmega = $isOmega;
        return $this;
    }

    /**
     * @return string
     */
    public function getRang(): string
    {
        return $this->rang;
    }

    /**
     * @param string $rang
     * @return Members
     */
    public function setRang(string $rang): Members
    {
        $this->rang = $rang;
        return $this;
    }
}
