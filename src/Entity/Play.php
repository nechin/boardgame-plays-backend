<?php

namespace App\Entity;

use App\Repository\PlayRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PlayRepository::class)
 * @ORM\Table(name="plays")
 */
class Play
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $Date;

    /**
     * @ORM\Column(type="smallint")
     */
    private $Count;

    /**
     * @ORM\ManyToOne(targetEntity=BoardGame::class, inversedBy="plays")
     * @ORM\JoinColumn(nullable=false)
     */
    private $BoardGame;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->Date;
    }

    public function setDate(\DateTimeInterface $Date): self
    {
        $this->Date = $Date;

        return $this;
    }

    public function getCount(): ?int
    {
        return $this->Count;
    }

    public function setCount(int $Count): self
    {
        $this->Count = $Count;

        return $this;
    }

    public function getBoardGame(): ?BoardGame
    {
        return $this->BoardGame;
    }

    public function setBoardGame(?BoardGame $BoardGame): self
    {
        $this->BoardGame = $BoardGame;

        return $this;
    }
}
