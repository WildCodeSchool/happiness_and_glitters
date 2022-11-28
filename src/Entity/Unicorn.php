<?php

namespace App\Entity;

use App\Repository\UnicornRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: UnicornRepository::class)]
#[Assert\EnableAutoMapping]
#[Vich\Uploadable]
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

    #[Vich\UploadableField(mapping: 'avatar', fileNameProperty: 'avatar')]
    #[Assert\File(
        maxSize: '2M',
        mimeTypes: ['image/jpeg', 'image/png', 'image/webp'],
    )]
    private ?File $avatarFile = null;

    #[ORM\Column(nullable: true)]
    private ?int $score = null;

    #[ORM\Column(nullable: true, options: ["default" => 0])]
    private ?int $fights = 0;

    #[ORM\Column(nullable: true, options: ["default" => 0])]
    private ?int $wonFights = 0;

    #[ORM\Column(nullable: true, options: ["default" => 0])]
    private ?int $lostFights = 0;

    #[ORM\Column(nullable: true, options: ["default" => 0])]
    private ?int $koFights = 0;

    #[ORM\ManyToMany(targetEntity: Attack::class, mappedBy: 'unicorns')]
    private Collection $attacks;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $updatedAt = null;

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

    /**
     * Get the value of avatarFile
     */
    public function getAvatarFile(): ?File
    {
        return $this->avatarFile;
    }

    /**
     * Set the value of avatarFile
     */
    public function setAvatarFile(?File $avatarFile = null): self
    {
        $this->avatarFile = $avatarFile;
        if ($avatarFile) {
            $this->updatedAt = new DateTime('now');
        }

        return $this;
    }

    /**
     * Get the value of updatedAt
     */
    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * Set the value of updatedAt
     */
    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
