<?php declare(strict_types=1);

namespace App\Entity;

use App\Repository\AnswerRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AnswerRepository::class)
 */
class Answer extends BaseEntity
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\Column(type="string", length=1)
     */
    private ?string $code;

    /**
     * @ORM\Column(type="text")
     */
    private ?string $label;

    /**
     * @ORM\Column(type="boolean")
     */
    private ?bool $correct;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $pollResult;

    /**
     * @ORM\ManyToOne(targetEntity=Question::class, inversedBy="answers")
     * @ORM\JoinColumn(nullable=false)
     */
    private ?Question $question;

    public function __toString() : string
    {
        return (string) $this->code;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

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

    public function getCorrect(): ?bool
    {
        return $this->correct;
    }

    /**
     * Alias.
     */
    public function isCorrect(): ?bool
    {
        return $this->getCorrect();
    }

    public function setCorrect(bool $correct): self
    {
        $this->correct = $correct;

        return $this;
    }

    public function getPollResult(): ?int
    {
        return $this->pollResult;
    }

    public function setPollResult(?int $pollResult): self
    {
        $this->pollResult = $pollResult;

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

    /* End basic 'etters ———————————————————————————————————————————————————— */

    public function getLabelWithCode(): string
    {
        return $this->getCode(). ': '.$this->getLabel();
    }
}
