<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\AnswerRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=AnswerRepository::class)
 */
final class Answer extends BaseEntity
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\Column(type="integer", name="`order`")
     * @Assert\PositiveOrZero
     */
    private int $order;

    /**
     * @ORM\Column(type="text")
     */
    private ?string $label;

    /**
     * @ORM\Column(type="float")
     */
    private float $score;

    /**
     * @ORM\ManyToOne(targetEntity=Question::class, inversedBy="answers")
     * @ORM\JoinColumn(nullable=false)
     */
    private ?Question $question;

    public function getOrder(): int
    {
        return $this->order;
    }

    public function setOrder(int $order): Answer
    {
        $this->order = $order;

        return $this;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(?string $label): Answer
    {
        $this->label = $label;

        return $this;
    }

    public function getScore(): float
    {
        return $this->score;
    }

    public function setScore(float $score): Answer
    {
        $this->score = $score;

        return $this;
    }

    public function getQuestion(): ?Question
    {
        return $this->question;
    }

    public function setQuestion(?Question $question): Answer
    {
        $this->question = $question;

        return $this;
    }
}
