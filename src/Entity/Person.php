<?php declare(strict_types=1);

namespace App\Entity;

use App\Repository\PersonRepository;
use Doctrine\ORM\Mapping as ORM;

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
    private ?int $id;

    /**
     * The Twitter account name without the "@".
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $twitter;

    /**
     * The pseudo of the person if they don't have a Twitter account.
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $pseudo;

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
}
