<?php

namespace App\Entity;

use App\Repository\QuestionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Blameable\Traits\BlameableEntity;

/**
 * @ORM\Entity(repositoryClass=QuestionRepository::class)
 */
class Question
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
    private $message;

    /**
     * @ORM\OneToMany(targetEntity=Response::class, mappedBy="previousQuestion")
     */
    private $responses;

    /**
     * @ORM\OneToOne(targetEntity=Response::class, mappedBy="nextQuestion", cascade={"persist", "remove"})
     */
    private $previousResponse;

    use TimestampableEntity;
    use BlameableEntity;

    public function __construct()
    {
        $this->responses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @return Collection|Response[]
     */
    public function getResponses(): Collection
    {
        return $this->responses;
    }

    public function addResponse(Response $response): self
    {
        if (!$this->responses->contains($response)) {
            $this->responses[] = $response;
            $response->setPreviousQuestion($this);
        }

        return $this;
    }

    public function removeResponse(Response $response): self
    {
        if ($this->responses->removeElement($response)) {
            // set the owning side to null (unless already changed)
            if ($response->getPreviousQuestion() === $this) {
                $response->setPreviousQuestion(null);
            }
        }

        return $this;
    }

    public function getPreviousResponse(): ?Response
    {
        return $this->previousResponse;
    }

    public function setPreviousResponse(?Response $previousResponse): self
    {
        // unset the owning side of the relation if necessary
        if ($previousResponse === null && $this->previousResponse !== null) {
            $this->previousResponse->setNextQuestion(null);
        }

        // set the owning side of the relation if necessary
        if ($previousResponse !== null && $previousResponse->getNextQuestion() !== $this) {
            $previousResponse->setNextQuestion($this);
        }

        $this->previousResponse = $previousResponse;

        return $this;
    }
}
