<?php declare(strict_types=1);

namespace App\Entity;

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
 */
class Question extends BaseEntity
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     *
     * @Groups({"show"})
     */
    protected ?int $id = null; // for the unit tests

    /**
     * Reminder to identify the quiz, it is thus a shorter version of the "$answerExplanations"
     * field.
     *
     * @ORM\Column(type="string", length=BaseEntity::STRING_DEFAULT_LENGTH)
     *
     * @example "Namespaces name can't start with an antslash "
     *
     * @Assert\NotBlank
     * @Assert\Length(max=BaseEntity::STRING_DEFAULT_LENGTH)
     */
    protected ?string $reminder;

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
    protected ?string $label;

    /**
     * The carbon image URL that was generated for Twitter.
     *
     * @example https://pbs.twimg.com/media/EdmGDDEXoAAcmsH?format=png&name=small
     *
     * @ORM\Column(type="string", length=BaseEntity::STRING_DEFAULT_LENGTH)
     *
     * @Assert\NotBlank
     * @Assert\Length(max=BaseEntity::STRING_DEFAULT_LENGTH)
     * @Assert\Url()
     */
    protected ?string $codeImage;

    /**
     * Some explanations about the correct answer.
     *
     * @ORM\Column(type="string", length=BaseEntity::STRING_DEFAULT_LENGTH)
     *
     * @example PHP namespaces can contain space characters, but they can't begin
     *          with a backslash. The right answer was "A"
     *
     * @Assert\NotBlank
     * @Assert\Length(max=BaseEntity::STRING_DEFAULT_LENGTH)
     */
    protected ?string $answerExplanations;

    /**
     * The testable snippet on the 3v4l.org website.
     *
     * @ORM\Column(type="string", length=BaseEntity::STRING_DEFAULT_LENGTH)
     *
     * @example https://3v4l.org/pQOMe
     *
     * @Assert\NotBlank
     * @Assert\Length(max=BaseEntity::STRING_DEFAULT_LENGTH)
     * @Assert\Url()
     */
    protected ?string $liveSnippetUrl;

    /**
     * The poll results on Twitter.
     *
     * @ORM\Column(type="string", length=BaseEntity::STRING_DEFAULT_LENGTH, nullable=true)
     *
     * @example https://twitter.com/FredBouchery/status/1286207302018699264
     *
     * @Assert\NotBlank
     * @Assert\Length(max=BaseEntity::STRING_DEFAULT_LENGTH)
     * @Assert\Url()
     */
    protected ?string $twitterPollUrl;

    /**
     * Additional notes if there is something to notice about the output between
     * PHP versions in cases there would be differences.
     *
     * @ORM\Column(type="text", nullable=true)
     *
     * @example With this last version, the exception message "Foo\Bar" is wrapped
     *          by double quotes instead of single quotes for other versions.
     */
    protected ?string $differencesOutputNotes;

    /**
     * List of possible answers for the question.
     *
     * @var Collection<int,Answer> $answers
     *
     * @ORM\OneToMany(targetEntity=Answer::class, mappedBy="question", orphanRemoval=true)
     */
    protected Collection $answers;

    /**
     * List of additional links for question, documentation, blog post, stackoverflow...
     *
     * @var Collection<int,Link>
     *
     * @ORM\OneToMany(targetEntity=Link::class, mappedBy="question", orphanRemoval=true)
     */
    protected Collection $links;

    /**
     * The person who has suggested the question.
     *
     * @ORM\ManyToOne(targetEntity=Person::class, inversedBy="questions")
     * @ORM\JoinColumn(nullable=false)
     *
     * @Assert\NotBlank()
     */
    protected ?Person $suggestedBy;

    /**
     * @ORM\OneToOne(targetEntity=Question::class, cascade={"persist", "remove"})
     */
    protected ?Question $previousQuestion;

    /**
     * @ORM\OneToOne(targetEntity=Question::class, cascade={"persist", "remove"})
     */
    protected ?Question $nextQuestion;

    public function __construct()
    {
        $this->answers = new ArrayCollection();
        $this->links = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->reminder. '('.$this->id.')';
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReminder(): ?string
    {
        return $this->reminder;
    }

    public function setReminder(string $reminder): self
    {
        $this->reminder = $reminder;

        return $this;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function getCodeImage(): ?string
    {
        return $this->codeImage;
    }

    public function setCodeImage(string $codeImage): self
    {
        $this->codeImage = $codeImage;

        return $this;
    }

    public function getAnswerExplanations(): ?string
    {
        return $this->answerExplanations;
    }

    public function setAnswerExplanations(string $answerExplanations): self
    {
        $this->answerExplanations = $answerExplanations;

        return $this;
    }

    public function getLiveSnippetUrl(): ?string
    {
        return $this->liveSnippetUrl;
    }

    public function setLiveSnippetUrl(string $liveSnippetUrl): self
    {
        $this->liveSnippetUrl = $liveSnippetUrl;

        return $this;
    }

    public function getTwitterPollUrl(): ?string
    {
        return $this->twitterPollUrl;
    }

    public function setTwitterPollUrl(?string $twitterPollUrl): self
    {
        $this->twitterPollUrl = $twitterPollUrl;

        return $this;
    }

    public function getDifferencesOutputNotes(): ?string
    {
        return $this->differencesOutputNotes;
    }

    public function setDifferencesOutputNotes(?string $differencesOutputNotes): self
    {
        $this->differencesOutputNotes = $differencesOutputNotes;

        return $this;
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

    /**
     * @return Collection<int,Link>
     */
    public function getLinks(): Collection
    {
        return $this->links;
    }

    public function addLink(Link $link): self
    {
        if (!$this->links->contains($link)) {
            $this->links[] = $link;
            $link->setQuestion($this);
        }

        return $this;
    }

    public function removeLink(Link $link): self
    {
        if ($this->links->contains($link)) {
            $this->links->removeElement($link);
            // set the owning side to null (unless already changed)
            if ($link->getQuestion() === $this) {
                $link->setQuestion(null);
            }
        }

        return $this;
    }

    public function getSuggestedBy(): ?Person
    {
        return $this->suggestedBy;
    }

    public function setSuggestedBy(?Person $suggestedBy): self
    {
        $this->suggestedBy = $suggestedBy;

        return $this;
    }

    public function getPreviousQuestion(): ?self
    {
        return $this->previousQuestion;
    }

    public function setPreviousQuestion(?self $previousQuestion): self
    {
        $this->previousQuestion = $previousQuestion;

        return $this;
    }

    public function getNextQuestion(): ?self
    {
        return $this->nextQuestion;
    }

    public function setNextQuestion(?self $nextQuestion): self
    {
        $this->nextQuestion = $nextQuestion;

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
        foreach ($this->getAnswers() as $answer) {
            if ($answer->isCorrect()) {
                return (string) $answer->getCode();
            }
        }

        throw new \LogicException("Question doesn't have a correct answer.");
    }
}
