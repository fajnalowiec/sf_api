<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints\NotNull;
use App\Repository\LovedGameRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: "loved_games")]
#[ORM\UniqueConstraint(name: "unique_player_game", columns: ['game_id', 'player_id'])]
#[ORM\Entity(repositoryClass: LovedGameRepository::class)]
class LovedGame
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotNull]
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(
        nullable: false,
        onDelete: "CASCADE",
    )]
    private ?Game $game = null;

    #[Assert\NotNull]
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(
        nullable: false,
        onDelete: "CASCADE",
    )]
    private ?Player $player = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGame(): ?Game
    {
        return $this->game;
    }

    public function setGame(?Game $game): static
    {
        $this->game = $game;

        return $this;
    }

    public function getPlayer(): ?Player
    {
        return $this->player;
    }

    public function setPlayer(?Player $player): static
    {
        $this->player = $player;

        return $this;
    }
}
