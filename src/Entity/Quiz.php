<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\QuizRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=QuizRepository::class)
 * @ORM\HasLifecycleCallbacks
 */
class Quiz extends BaseEntity
{
    /**
     * Uniq identifier for a quiz.
     *
     * @ORM\Id
     * @ORM\Column(type="string", length=BaseEntity::STRING_DEFAULT_LENGTH)
     */
    protected string $id;
    /**
     * @ORM\Column(type="string", length=BaseEntity::STRING_DEFAULT_LENGTH)
     *
     * @Assert\NotBlank
     * @Assert\Length(max=BaseEntity::STRING_DEFAULT_LENGTH)
     */
    private string $label;

    /**
     * @ORM\Column(type="text")
     *
     * @Assert\NotBlank
     */
    private string $description;

    /**
     * @ORM\Column(type="integer")
     * @Assert\PositiveOrZero()
     */
    private int $difficulty;

    /**
     * @var Collection<int,Question>
     *
     * @ORM\ManyToMany(targetEntity="Question")
     * @ORM\JoinTable(
     *     name="quiz_question",
     *     joinColumns={@ORM\JoinColumn(name="quiz_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="question_id", referencedColumnName="id", unique=true)}
     * )
     */
    protected Collection $questions;

    public function __construct()
    {
        $this->questions = new ArrayCollection();
    }

    /**
     * @return Question[]|Collection
     */
    public function getQuestions(): Collection
    {
        return $this->questions;
    }

    public function addQuestion(Question $question): self
    {
        if (!$this->questions->contains($question)) {
            $this->questions[] = $question;
        }

        return $this;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): Quiz
    {
        $this->id = $id;

        return $this;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function setLabel(string $label): Quiz
    {
        $this->label = $label;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): Quiz
    {
        $this->description = $description;

        return $this;
    }

    public function getDifficulty(): int
    {
        return $this->difficulty;
    }

    public function setDifficulty(int $difficulty): Quiz
    {
        $this->difficulty = $difficulty;

        return $this;
    }
}
