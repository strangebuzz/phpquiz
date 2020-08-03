<?php declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Person;
use App\Entity\Question;
use Symfony\Component\Config\Definition\Exception\InvalidTypeException;

trait AppFixturesTrait
{
    /**
     * @var array<int,Question>
     */
    private array $questions = [];

    /**
     * @var array<int,Person>
     */
    private array $persons = [];

    private function getQuestion(int $id): Question
    {
        if (isset($this->questions[$id])) {
            return $this->questions[$id];
        }

        $question = $this->getReference(QuestionFixtures::class.$id);
        if (!$question instanceof Question) {
            throw new InvalidTypeException(sprintf('Question "%d" not found.', $id));
        }

        $this->questions[$id] = $question;

        return $question;
    }

    private function getPerson(int $id): Person
    {
        if (isset($this->persons[$id])) {
            return $this->persons[$id];
        }

        $person = $this->getReference(PersonFixtures::class.$id);
        if (!$person instanceof Person) {
            throw new InvalidTypeException(sprintf('Person "%d" not found.', $id));
        }

        $this->persons[$id] = $person;

        return $person;
    }
}
