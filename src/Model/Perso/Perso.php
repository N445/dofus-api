<?php

namespace App\Model\Perso;

use App\Model\Perso\Guilde;

class Perso
{
    /**
     * @var
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
     * @var boolean
     */
    private $isOmega = false;

    /**
     * @var string
     */
    private $classe;

    /**
     * @var string|null
     */
    private $grade;

    /**
     * @var string
     */
    private $server;

    /**
     * @var integer
     */
    private $successPoints;

    /**
     * @var array
     */
    private $metiers;

    /**
     * @var Guilde|null
     */
    private $guilde;

    /**
     * Perso constructor.
     * @param $id
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return Perso
     */
    public function setId($id)
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
     * @return Perso
     */
    public function setName(string $name): Perso
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
     * @return Perso
     */
    public function setLevel(int $level): Perso
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
     * @return Perso
     */
    public function setIsOmega(bool $isOmega): Perso
    {
        $this->isOmega = $isOmega;
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
     * @return Perso
     */
    public function setClasse(string $classe): Perso
    {
        $this->classe = $classe;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getGrade(): ?string
    {
        return $this->grade;
    }

    /**
     * @param string|null $grade
     * @return Perso
     */
    public function setGrade(?string $grade): Perso
    {
        $this->grade = $grade;
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
     * @return Perso
     */
    public function setServer(string $server): Perso
    {
        $this->server = $server;
        return $this;
    }

    /**
     * @return int
     */
    public function getSuccessPoints(): int
    {
        return $this->successPoints;
    }

    /**
     * @param int $successPoints
     * @return Perso
     */
    public function setSuccessPoints(int $successPoints): Perso
    {
        $this->successPoints = $successPoints;
        return $this;
    }

    /**
     * @return array
     */
    public function getMetiers(): array
    {
        return $this->metiers;
    }

    /**
     * @param Metier $metier
     * @return Perso
     */
    public function addMetiers(Metier $metier): Perso
    {
        $this->metiers[] = $metier;
        return $this;
    }

    /**
     * @param Metier[] $metiers
     * @return Perso
     */
    public function setMetiers(array $metiers): Perso
    {
        $this->metiers = $metiers;
        return $this;
    }

    /**
     * @return Guilde|null
     */
    public function getGuilde(): ?Guilde
    {
        return $this->guilde;
    }

    /**
     * @param Guilde|null $guilde
     * @return Perso
     */
    public function setGuilde(?Guilde $guilde): Perso
    {
        $this->guilde = $guilde;
        return $this;
    }

}
