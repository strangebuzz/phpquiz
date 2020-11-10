<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\QuizQuestionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=QuizQuestionRepository::class)
 */
class QuizQuestion extends BaseEntity
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected ?int $id;

    /**
     * @ORM\ManyToOne(targetEntity=Quiz::class, inversedBy="questions")
     * @ORM\JoinColumn(nullable=false)
     */
    protected ?Quiz $quiz;

    /**
     * @ORM\ManyToOne(targetEntity=Question::class)
     * @ORM\JoinColumn(nullable=false)
     */
    protected ?Question $question;

    /**
     * @ORM\ManyToOne(targetEntity=Answer::class)
     */
    protected ?Answer $answer;

    /**
     * @ORM\Column(type="integer")
     */
    private ?int $rank;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuiz(): ?Quiz
    {
        return $this->quiz;
    }

    public function setQuiz(?Quiz $quiz): self
    {
        $this->quiz = $quiz;

        return $this;
    }

    public function getQuestion(): ?Question
    {
        return $this->question;
    }

    public function setQuestion(?Question $question): self
    {
        $this->question = $question;

        return $this;
    }

    public function getAnswer(): ?Answer
    {
        return $this->answer;
    }

    public function setAnswer(?Answer $answer): self
    {
        $this->answer = $answer;

        return $this;
    }

    public function getRank(): ?int
    {
        return $this->rank;
    }

    public function setRank(int $rank): self
    {
        $this->rank = $rank;

        return $this;
    }
}
