<?php

namespace App\Model\Perso;

class Metier
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var integer
     */
    private $level;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Metier
     */
    public function setName(string $name): Metier
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
     * @return Metier
     */
    public function setLevel(int $level): Metier
    {
        $this->level = $level;
        return $this;
    }
}
