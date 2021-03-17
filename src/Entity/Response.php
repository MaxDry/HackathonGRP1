<?php

namespace App\Entity;

use App\Repository\ResponseRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Blameable\Traits\BlameableEntity;

/**
 * @ORM\Entity(repositoryClass=ResponseRepository::class)
 */
class Response
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Question::class, inversedBy="responses")
     */
    private $previousQuestion;

    /**
     * @ORM\OneToOne(targetEntity=Question::class, inversedBy="previousResponse", cascade={"persist", "remove"})
     */
    private $nextQuestion;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $message;

    use TimestampableEntity;
    use BlameableEntity;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPreviousQuestion(): ?Question
    {
        return $this->previousQuestion;
    }

    public function setPreviousQuestion(?Question $previousQuestion): self
    {
        $this->previousQuestion = $previousQuestion;

        return $this;
    }

    public function getNextQuestion(): ?Question
    {
        return $this->nextQuestion;
    }

    public function setNextQuestion(?Question $nextQuestion): self
    {
        $this->nextQuestion = $nextQuestion;

        return $this;
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
}
