<?php declare(strict_types=1);

namespace App\Entity;

use App\Repository\PersonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Config\Definition\Exception\InvalidTypeException;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * The Twitter or pseudo should be filled.
 *
 * @ORM\Entity(repositoryClass=PersonRepository::class)
 */
class Person
{
    use TimestampableEntityTrait;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * The Twitter account name without the "@".
     *
     * @ORM\Column(type="string", length=255, nullable=true, unique=true)
     */
    private ?string $twitter = null;

    /**
     * The pseudo of the person if they don't have a Twitter account.
     *
     * @ORM\Column(type="string", length=255, nullable=true, unique=true)
     */
    private ?string $pseudo = null;

    /**
     * @var Collection<int,Question>
     *
     * @ORM\OneToMany(targetEntity=Question::class, mappedBy="suggestedBy", orphanRemoval=true)
     */
    private Collection $questions;

    public function __construct()
    {
        $this->questions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTwitter(): ?string
    {
        return $this->twitter;
    }

    public function setTwitter(?string $twitter): self
    {
        $this->twitter = $twitter;

        return $this;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(?string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    /**
     * @return Collection<int,Question>
     */
    public function getQuestions(): Collection
    {
        return $this->questions;
    }

    public function addQuestion(Question $question): self
    {
        if (!$this->questions->contains($question)) {
            $this->questions[] = $question;
            $question->setSuggestedBy($this);
        }

        return $this;
    }

    public function removeQuestion(Question $question): self
    {
        if ($this->questions->contains($question)) {
            $this->questions->removeElement($question);
            // set the owning side to null (unless already changed)
            if ($question->getSuggestedBy() === $this) {
                $question->setSuggestedBy(null);
            }
        }

        return $this;
    }

    /* End basic 'etters ———————————————————————————————————————————————————— */

    /**
     * @Assert\Callback
     */
    public function validate(ExecutionContextInterface $context): void
    {
        $person = $context->getValue();
        if (!$person instanceof self) {
            throw new InvalidTypeException('Invalid type, a Person is expected.');
        }

        if ($person->getTwitter() && $person->getPseudo()) {
            $context->buildViolation('You should fill the Twitter or the pseudo, but not both.')
                ->atPath('twitter')
                ->addViolation();
        }
    }
}
