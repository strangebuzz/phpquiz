<?php declare(strict_types=1);

namespace App\Entity;

use App\Repository\QuestionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Represents a quiz question. A question is standalone and can be used without being
 * part of a multiple questions quiz. A question has several answers.
 *
 * @ORM\Entity(repositoryClass=QuestionRepository::class)
 */
class Question
{
    use TimestampableEntityTrait;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected ?int $id;

    /**
     * Just a sentence to introduce the code.
     *
     * @example "What will be displayed?"
     *
     * @ORM\Column(type="string", length=255)
     */
    protected ?string $label;

    /**
     * The carbon image URL that was generated for Twitter.
     *
     * @example https://pbs.twimg.com/media/EdmGDDEXoAAcmsH?format=png&name=small
     *
     * @ORM\Column(type="string", length=255)
     */
    protected ?string $codeImage;

    /**
     * Some explanations about the correct answer.
     *
     * @ORM\Column(type="string", length=255)
     *
     * @example PHP namespaces can contain space characters, but they can't begin
     *          with a backslash. The right answer was "A"
     */
    protected ?string $answerExplanations;

    /**
     * The testable snippet on the 3v4l.org website.
     *
     * @ORM\Column(type="string", length=255)
     *
     * @example https://3v4l.org/pQOMe
     */
    protected ?string $liveSnippetUrl;

    /**
     * The poll results on Twitter.
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @example https://twitter.com/FredBouchery/status/1286207302018699264
     */
    protected ?string $twitterPollUrl;

    /**
     * Additional notes if there is something to notice about the output between
     * version in the cases there would be differences.
     *
     * @ORM\Column(type="text", nullable=true)
     *
     * @example With this last version, the exception message "Foo\Bar" is wrapped
     *          by double quotes instead of single quotes for other versions.
     */
    protected ?string $differencesOutputNotes;

    public function getId(): ?int
    {
        return $this->id;
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
}
