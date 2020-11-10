<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Answer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AnswerFixtures extends Fixture implements DependentFixtureInterface
{
    use AppFixturesTrait;

    public function load(ObjectManager $manager): void
    {
        foreach ($this->loadYaml(self::class)['answers'] ?? [] as $questionId => $questions) {
            $question = $this->getQuestion($questionId);
            foreach ($questions as $questionArr) {
                [$code, $label, $correct, $pollResult] = array_values($questionArr);
                $answer = (new Answer())
                    ->setCode($code)
                    ->setLabel($label)
                    ->setQuestion($question)
                    ->setCorrect($correct)
                    ->setPollResult((int) $pollResult);

                $manager->persist($answer);
            }
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            QuestionFixtures::class,
        ];
    }
}
