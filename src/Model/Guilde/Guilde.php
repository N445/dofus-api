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
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var Members[]
     */
    private $members;

    /**
     * Guilde constructor.
     * @param string $id
     */
    public function __construct(string $id)
    {
        $this->id = $id;
    }

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

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     * @return Guilde
     */
    public function setCreatedAt(\DateTime $createdAt): Guilde
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return Members[]
     */
    public function getMembers(): array
    {
        return $this->members;
    }

    /**
     * @param Members[] $members
     * @return Guilde
     */
    public function setMembers(array $members): Guilde
    {
        $this->members = $members;
        return $this;
    }
    /**
     * @param Members $member
     * @return Guilde
     */
    public function addMember(Members $member): Guilde
    {
        $this->members[] = $member;
        return $this;
    }
}
