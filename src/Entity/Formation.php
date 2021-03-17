<?php

namespace App\Entity;

use App\Repository\FormationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Blameable\Traits\BlameableEntity;

/**
 * @ORM\Entity(repositoryClass=FormationRepository::class)
 */
class Formation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $catalog_link;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $eLearning_link;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_active;

    /**
     * @ORM\ManyToMany(targetEntity=TrainingManager::class, mappedBy="formations")
     */
    private $trainingManagers;

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

    public function getCatalogLink(): ?string
    {
        return $this->catalog_link;
    }

    public function setCatalogLink(?string $catalog_link): self
    {
        $this->catalog_link = $catalog_link;

        return $this;
    }

    public function getELearningLink(): ?string
    {
        return $this->eLearning_link;
    }

    public function setELearningLink(?string $eLearning_link): self
    {
        $this->eLearning_link = $eLearning_link;

        return $this;
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
            $trainingManager->addFormation($this);
        }

        return $this;
    }

    public function removeTrainingManager(TrainingManager $trainingManager): self
    {
        if ($this->trainingManagers->removeElement($trainingManager)) {
            $trainingManager->removeFormation($this);
        }

        return $this;
    }
}
