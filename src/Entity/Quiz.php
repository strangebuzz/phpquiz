<?php declare(strict_types=1);

namespace App\Entity;

use _HumbugBox71425477b33d\Symfony\Component\Console\Exception\LogicException;
use App\Repository\QuizRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @todo delete add/remove questions methods?
 *
 * @ORM\Entity(repositoryClass=QuizRepository::class)
 */
class Quiz extends BaseEntity
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected ?int $id;

    /**
     * @ORM\Column(type="guid")
     */
    protected ?string $uuid;

    /**
     * @var Collection<int,QuizQuestion> $questions
     *
     * @ORM\OneToMany(targetEntity=QuizQuestion::class, mappedBy="quiz")
     */
    protected Collection $questions;

    public function __construct()
    {
        $this->questions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    public function setUuid(string $uuid): self
    {
        $this->uuid = $uuid;

        return $this;
    }

    /**
     * @return Collection<int,QuizQuestion>|QuizQuestion[]
     */
    public function getQuestions(): Collection
    {
        return $this->questions;
    }

    public function addQuestion(QuizQuestion $question): self
    {
        if (!$this->questions->contains($question)) {
            $this->questions[] = $question;
            $question->setQuiz($this);
        }

        return $this;
    }

    public function removeQuestion(QuizQuestion $question): self
    {
        if ($this->questions->contains($question)) {
            $this->questions->removeElement($question);
            // set the owning side to null (unless already changed)
            if ($question->getQuiz() === $this) {
                $question->setQuiz(null);
            }
        }

        return $this;
    }

    /* End basic 'etters ———————————————————————————————————————————————————— */
}
