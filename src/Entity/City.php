<?php

namespace App\Entity;

use App\Repository\CityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Blameable\Traits\BlameableEntity;

/**
 * @ORM\Entity(repositoryClass=CityRepository::class)
 */
class City
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Le nom de ville ne peut pas être vide")
     * @Assert\Length(
     *    min = 2,
     *    max = 50,
     *    minMessage = "Le nom de ville doit faire au moins 2 caractères",
     *    maxMessage = "Le nom de ville faire au maximum 50 caractères",
     * )
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=TrainingManager::class, mappedBy="city")
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

    use TimestampableEntity;
    use BlameableEntity;

    public function __construct()
    {
        $this->trainingManagers = new ArrayCollection();
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
            $trainingManager->setCity($this);
        }

        return $this;
    }

    public function removeTrainingManager(TrainingManager $trainingManager): self
    {
        if ($this->trainingManagers->removeElement($trainingManager)) {
            // set the owning side to null (unless already changed)
            if ($trainingManager->getCity() === $this) {
                $trainingManager->setCity(null);
            }
        }

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

    public function __toString()
    {
       return $this->name;
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
