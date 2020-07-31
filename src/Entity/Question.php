<?php declare(strict_types=1);

namespace App\Entity;

use App\Repository\QuestionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=QuestionRepository::class)
 */
class Question
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Just a sentence to introduce the code.
     *
     * @example "What will be displayed?"
     *
     * @ORM\Column(type="string", length=255)
     */
    private $label;

    /**
     * The carbon image URL that was generated for Twitter.
     *
     * @example https://pbs.twimg.com/media/EdmGDDEXoAAcmsH?format=png&name=small
     *
     * @ORM\Column(type="string", length=255)
     */
    private $codeImage;

    /**
     * Some explanations about the correct answer.
     *
     * @ORM\Column(type="string", length=255)
     *
     * @example PHP namespaces can contain space characters, but they can't begin with a backslash. The right answer was "A"
     */
    private $answerExplanation;

    /**
     * The testable snippet on the 3v4l.org website.
     *
     * @ORM\Column(type="string", length=255)
     *
     * @example https://3v4l.org/pQOMe
     */
    private $liveSnippetUrl;

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

    public function getAnswerExplanation(): ?string
    {
        return $this->answerExplanation;
    }

    public function setAnswerExplanation(string $answerExplanation): self
    {
        $this->answerExplanation = $answerExplanation;

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
}
