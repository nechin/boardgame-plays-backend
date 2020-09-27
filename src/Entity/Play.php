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
    private ?int $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private \DateTime $date;

    /**
     * @ORM\Column(type="smallint")
     */
    private int $count;

    /**
     * @ORM\ManyToOne(targetEntity=BoardGame::class, inversedBy="plays")
     * @ORM\JoinColumn(nullable=false)
     */
    private ?BoardGame $boardGame;

    /**
     * Play constructor.
     */
    public function __construct()
    {
        $this->date = new \DateTime();
        $this->count = 1;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTime
    {
        return $this->date;
    }

    public function setDate(\DateTime $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getCount(): ?int
    {
        return $this->count;
    }

    public function setCount(int $count): self
    {
        $this->count = $count;

        return $this;
    }

    public function getBoardGame(): ?BoardGame
    {
        return $this->boardGame;
    }

    public function setBoardGame(?BoardGame $boardGame): self
    {
        $this->boardGame = $boardGame;

        return $this;
    }
}
