<?php

namespace App\Entity;

use App\Repository\AttackRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AttackRepository::class)]
#[Assert\EnableAutoMapping]
class Attack
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 45)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $avatar = null;

    #[ORM\Column(nullable: false, options: ["default" => 1])]
    #[Assert\GreaterThan(0)]
    private int $cost = 0;

    #[ORM\Column(nullable: false, options: ["default" => 1])]
    #[Assert\GreaterThan(0)]
    private int $gain = 0;

    #[ORM\Column(nullable: false, options: ["default" => 100])]
    private int $successRate = 0;

    #[ORM\ManyToMany(targetEntity: Unicorn::class, inversedBy: 'attacks')]
    private Collection $unicorns;

    public function __construct()
    {
        $this->unicorns = new ArrayCollection();
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

    public function getCost(): ?int
    {
        return $this->cost;
    }

    public function setCost(?int $cost): self
    {
        $this->cost = $cost;

        return $this;
    }

    public function getGain(): ?int
    {
        return $this->gain;
    }

    public function setGain(?int $gain): self
    {
        $this->gain = $gain;

        return $this;
    }

    public function getSuccessRate(): ?int
    {
        return $this->successRate;
    }

    public function setSuccessRate(?int $successRate): self
    {
        $this->successRate = $successRate;

        return $this;
    }

    /**
     * @return Collection<int, Unicorn>
     */
    public function getUnicorns(): Collection
    {
        return $this->unicorns;
    }

    public function addUnicorn(Unicorn $unicorn): self
    {
        if (!$this->unicorns->contains($unicorn)) {
            $this->unicorns->add($unicorn);
        }

        return $this;
    }

    public function removeUnicorn(Unicorn $unicorn): self
    {
        $this->unicorns->removeElement($unicorn);

        return $this;
    }
}
