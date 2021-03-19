<?php

namespace App\Entity;

use App\Repository\ProfileRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Blameable\Traits\BlameableEntity;

/**
 * @ORM\Entity(repositoryClass=ProfileRepository::class)
 */
class Profile
{
    public const ROLES = [
        'utilisateur' => [
            'ROLE_USER',
            'ROLE_USER_SHOW',
            'ROLE_USER_NEW',
            'ROLE_USER_EDIT',
            'ROLE_USER_DELETE',
        ],
        'profil' => [
            'ROLE_PROFILE',
            'ROLE_PROFILE_SHOW',
            'ROLE_PROFILE_NEW',
            'ROLE_PROFILE_EDIT',
            'ROLE_PROFILE_DELETE',
        ],
        'team' => [
            'ROLE_TEAM',
            'ROLE_TEAM_SHOW',
            'ROLE_TEAM_NEW',
            'ROLE_TEAM_EDIT',
            'ROLE_TEAM_DELETE',
        ],
        'formation' => [
            'ROLE_FORMATION',
            'ROLE_FORMATION_SHOW',
            'ROLE_FORMATION_NEW',
            'ROLE_FORMATION_EDIT',
            'ROLE_FORMATION_DELETE',
        ],
        'city' => [
            'ROLE_CITY',
            'ROLE_CITY_SHOW',
            'ROLE_CITY_NEW',
            'ROLE_CITY_EDIT',
            'ROLE_CITY_DELETE',
        ],
        'trainingManager' => [
            'ROLE_TRAINING_MANAGER',
            'ROLE_TRAINING_MANAGER_SHOW',
            'ROLE_TRAINING_MANAGER_NEW',
            'ROLE_TRAINING_MANAGER_EDIT',
            'ROLE_TRAINING_MANAGER_DELETE',
        ],
        'trainingMeasure' => [
            'ROLE_TRAINING_MEASURE',
            'ROLE_TRAINING_MEASURE_SHOW',
            'ROLE_TRAINING_MEASURE_NEW',
            'ROLE_TRAINING_MEASURE_EDIT',
            'ROLE_TRAINING_MEASURE_DELETE',
        ],
    ];

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="le nom de famille ne peut pas être vide")
     * @Assert\Length(
     *    min = 2,
     *    max = 50,
     *    minMessage = "Le nom doit faire au moins 2 caractères",
     *    maxMessage = "Le nom doit faire au maximum 50 caractères",
     * )
     */
    private $name;

    /**
     * @ORM\Column(type="simple_array", nullable=true)
     */
    private $roles = [];

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="profile")
     */
    private $users;

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
        $this->users = new ArrayCollection();
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

    public function getRoles(): ?array
    {
        return $this->roles;
    }

    public function setRoles(?array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setProfile($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getProfile() === $this) {
                $user->setProfile(null);
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
