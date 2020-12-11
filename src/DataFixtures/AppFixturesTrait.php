<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Difficulty;
use App\Entity\Person;
use App\Entity\Question;
use App\Entity\Quiz;
use Symfony\Component\Config\Definition\Exception\InvalidTypeException;
use Symfony\Component\Yaml\Yaml;

trait AppFixturesTrait
{
    private function getQuestion(int $id): Question
    {
        $question = $this->getReference(QuestionFixtures::class.':'.$id);
        if (!$question instanceof Question) {
            throw new InvalidTypeException(sprintf('Question "%d" not found.', $id));
        }

        return $question;
    }

    private function getPerson(string $pseudo): Person
    {
        $person = $this->getReference($pseudo);
        if (!$person instanceof Person) {
            throw new InvalidTypeException(sprintf('Person "%d" not found.', $pseudo));
        }

        return $person;
    }

    private function getQuiz(int $id): Quiz
    {
        $quiz = $this->getReference(QuizFixtures::class.$id);
        if (!$quiz instanceof Quiz) {
            throw new InvalidTypeException(sprintf('Quiz "%d" not found.', $id));
        }

        return $quiz;
    }

    /**
     * @return array<string,array>
     */
    private function loadYaml(string $class): array
    {
        $classInfo = explode('\\', $class);
        $yaml = Yaml::parseFile(__DIR__.'/'.($classInfo[2] ?? '').'.yaml');
        if (!is_array($yaml)) {
            throw new \RuntimeException('Invalid YAML data.');
        }

        return $yaml;
    }
}
