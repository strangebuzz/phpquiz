<?php declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Question;
use Symfony\Component\Config\Definition\Exception\InvalidTypeException;

trait AppFixturesTrait
{
    /**
     * @var array<int,Question>
     */
    private array $questions = [];

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
}
