<?php

namespace App\Entity;

use App\Repository\UnicornRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UnicornRepository::class)]
class Unicorn
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 45)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $avatar = null;

    #[ORM\Column(nullable: true)]
    private ?int $score = null;

    #[ORM\Column(nullable: true, options: ["default" => 0])]
    private ?int $fights = null;

    #[ORM\Column(nullable: true, options: ["default" => 0])]
    private ?int $wonFights = null;

    #[ORM\Column(nullable: true, options: ["default" => 0])]
    private ?int $lostFights = null;

    #[ORM\Column(nullable: true, options: ["default" => 0])]
    private ?int $koFights = null;

    #[ORM\ManyToMany(targetEntity: Attack::class, mappedBy: 'unicorns')]
    private Collection $attacks;

    public function __construct()
    {
        $this->attacks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(?string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getScore(): ?int
    {
        return $this->score;
    }

    public function setScore(?int $score): self
    {
        $this->score = $score;

        return $this;
    }

    public function getFights(): ?int
    {
        return $this->fights;
    }

    public function setFights(?int $fights): self
    {
        $this->fights = $fights;

        return $this;
    }

    public function getWonFights(): ?int
    {
        return $this->wonFights;
    }

    public function setWonFights(?int $wonFights): self
    {
        $this->wonFights = $wonFights;

        return $this;
    }

    public function getLostFights(): ?int
    {
        return $this->lostFights;
    }

    public function setLostFights(?int $lostFights): self
    {
        $this->lostFights = $lostFights;

        return $this;
    }

    public function getKoFights(): ?int
    {
        return $this->koFights;
    }

    public function setKoFights(?int $koFights): self
    {
        $this->koFights = $koFights;

        return $this;
    }

    /**
     * @return Collection<int, Attack>
     */
    public function getAttacks(): Collection
    {
        return $this->attacks;
    }

    public function addAttack(Attack $attack): self
    {
        if (!$this->attacks->contains($attack)) {
            $this->attacks->add($attack);
            $attack->addUnicorn($this);
        }

        return $this;
    }

    public function removeAttack(Attack $attack): self
    {
        if ($this->attacks->removeElement($attack)) {
            $attack->removeUnicorn($this);
        }

        return $this;
    }
}
