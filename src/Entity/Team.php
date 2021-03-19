<?php

namespace App\Entity;

use App\Repository\TeamRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Blameable\Traits\BlameableEntity;

/**
 * @ORM\Entity(repositoryClass=TeamRepository::class)
 */
class Team
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="le nom d'équipe ne peut pas être vide")
     * @Assert\Length(
     *    min = 2,
     *    max = 50,
     *    minMessage = "Le nom d'équipe doit faire au moins 2 caractères",
     *    maxMessage = "Le nom d'équipe doit faire au maximum 50 caractères",
     * )
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $picture;

    /**
     * @ORM\OneToMany(targetEntity=TrainingManager::class, mappedBy="team")
     */
    private $trainingManagers;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_active;

    /**
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(type="string", unique=true)
     */
    private $slug;

    public function __construct()
    {
        $this->trainingManagers = new ArrayCollection();
    }

    use TimestampableEntity;
    use BlameableEntity;

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

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * @return Collection|TrainingManager[]
     */
    public function getTrainingManagers(): Collection
    {
        return $this->trainingManagers;
    }

    public function addTrainingManager(TrainingManager $trainingManager): self
    {
        if (!$this->trainingManagers->contains($trainingManager)) {
            $this->trainingManagers[] = $trainingManager;
            $trainingManager->setTeam($this);
        }

        return $this;
    }

    public function removeTrainingManager(TrainingManager $trainingManager): self
    {
        if ($this->trainingManagers->removeElement($trainingManager)) {
            // set the owning side to null (unless already changed)
            if ($trainingManager->getTeam() === $this) {
                $trainingManager->setTeam(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
       return $this->name;
    }

    public function getIsActive(): ?bool
    {
        return $this->is_active;
    }

    public function setIsActive(bool $is_active): self
    {
        $this->is_active = $is_active;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }
}
