<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\QuestionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Represents a quiz question. A question is standalone and can be used without being
 * part of a multiple questions quiz. A question has several answers.
 *
 * @ORM\Entity(repositoryClass=QuestionRepository::class)
 *
 * @ApiResource(
 *     collectionOperations={"get"},
 *     itemOperations={"get"},
 *     normalizationContext={"groups"={"show"}},
 *     denormalizationContext={"groups"={"show"}}
 * )
 */
final class Question extends BaseEntity
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     *
     * @Groups({"show"})
     */
    private int $id; // for the unit tests

    /**
     * Just a sentence to introduce the code.
     *
     * @example "What will be displayed?"
     *
     * @ORM\Column(type="string", length=BaseEntity::STRING_DEFAULT_LENGTH)
     *
     * @Assert\NotBlank
     * @Assert\Length(max=BaseEntity::STRING_DEFAULT_LENGTH)
     */
    private string $label;

    /**
     * Question details written with markdown syntax.
     *
     * @example "Is true == '3apples' ?"
     *
     * @ORM\Column(type="text")
     *
     * @Assert\NotBlank
     */
    private string $description;

    /**
     * Some explanations about the correct answer.
     *
     * @example PHP namespaces can contain space characters, but they can't begin
     *          with a backslash. The right answer was "A"
     *
     * @ORM\Column(type="text")
     *
     * @Assert\NotBlank
     */
    private string $answerExplanations;

    /**
     * Url where the question came from.
     *
     * @ORM\Column(type="string", length=BaseEntity::STRING_DEFAULT_LENGTH, nullable=true)
     *
     * @example https://twitter.com/FredBouchery/status/1286207302018699264
     *
     * @Assert\NotBlank
     * @Assert\Length(max=BaseEntity::STRING_DEFAULT_LENGTH)
     * @Assert\Url()
     */
    private ?string $sourceUrl;

    /**
     * List of possible answers for the question.
     *
     * @var Collection<int,Answer>
     *
     * @ORM\OneToMany(targetEntity=Answer::class, mappedBy="question", orphanRemoval=true, fetch="EAGER")
     */
    private Collection $answers;

    /**
     * The person who has suggested the question.
     *
     * @ORM\ManyToOne(targetEntity=Person::class, inversedBy="questions", fetch="EAGER")
     * @ORM\JoinColumn(nullable=false)
     *
     * @Assert\NotBlank
     */
    private ?Person $suggestedBy;

    /**
     * @ORM\Column(type="integer")
     * @Assert\PositiveOrZero()
     */
    private int $difficulty;

    public function __construct()
    {
        $this->answers = new ArrayCollection();
    }

    /**
     * @return Collection<int,Answer>|Answer[]
     */
    public function getAnswers(): Collection
    {
        return $this->answers;
    }

    public function addAnswer(Answer $answer): self
    {
        if (!$this->answers->contains($answer)) {
            $this->answers[] = $answer;
            $answer->setQuestion($this);
        }

        return $this;
    }

    public function removeAnswer(Answer $answer): self
    {
        if ($this->answers->contains($answer)) {
            $this->answers->removeElement($answer);
            // set the owning side to null (unless already changed)
            if ($answer->getQuestion() === $this) {
                $answer->setQuestion(null);
            }
        }

        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): Question
    {
        $this->id = $id;

        return $this;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function setLabel(string $label): Question
    {
        $this->label = $label;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): Question
    {
        $this->description = $description;

        return $this;
    }

    public function getAnswerExplanations(): string
    {
        return $this->answerExplanations;
    }

    public function setAnswerExplanations(string $answerExplanations): Question
    {
        $this->answerExplanations = $answerExplanations;

        return $this;
    }

    public function getSourceUrl(): ?string
    {
        return $this->sourceUrl;
    }

    public function setSourceUrl(?string $sourceUrl): Question
    {
        $this->sourceUrl = $sourceUrl;

        return $this;
    }

    public function getSuggestedBy(): ?Person
    {
        return $this->suggestedBy;
    }

    public function setSuggestedBy(?Person $suggestedBy): Question
    {
        $this->suggestedBy = $suggestedBy;

        return $this;
    }

    public function getDifficulty(): int
    {
        return $this->difficulty;
    }

    public function setDifficulty(int $difficulty): Question
    {
        $this->difficulty = $difficulty;

        return $this;
    }

    /* End basic 'etters ———————————————————————————————————————————————————— */

    /**
     * Virtual property getter.
     *
     * @Groups({"show"})
     *
     * @throws \LogicException
     */
    public function getCorrectAnswerCode(): string
    {
        $correctAnswer = null;
        foreach ($this->getAnswers() as $answer) {
            if (null !== $correctAnswer && $answer->isCorrect()) {
                throw new \LogicException('Question has more than a correct answer.');
            }

            if (null === $correctAnswer && $answer->isCorrect()) {
                $correctAnswer = $answer;
            }
        }

        if (null === $correctAnswer) {
            throw new \LogicException("Question doesn't have a correct answer.");
        }

        return (string) $correctAnswer->getCode();
    }
}
