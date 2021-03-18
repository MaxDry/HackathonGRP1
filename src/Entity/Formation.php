<?php

namespace App\Entity;

use App\Repository\FormationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
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
     * @Assert\NotBlank(message="Le nom ne peut pas être vide")
     * @Assert\Length(
     *    min = 2,
     *    max = 50,
     *    minMessage = "Le nom doit faire au moins 2 caractères",
     *    maxMessage = "Le nom doit faire au maximum 50 caractères",
     * )
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Url(
     *    message = "L'url '{{ value }}' n'est pas une url valide",
     * )
     */
    private $catalog_link;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Url(
     *    message = "L'url '{{ value }}' n'est pas une url valide",
     * )
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
