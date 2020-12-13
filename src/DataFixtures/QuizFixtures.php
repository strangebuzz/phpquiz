<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Quiz;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class QuizFixtures extends Fixture implements DependentFixtureInterface
{
    use AppFixturesTrait;

    public function load(ObjectManager $manager): void
    {
        foreach ($this->loadYaml(self::class)['quiz'] as $id => $data) {
            $quiz = (new Quiz())
                //->setId($id)
                ->setLabel($data['label'])
                ->setDescription($data['description'])
                ->setDifficulty($data['difficulty'])
            ;

            foreach ($data['questions'] as $questionId) {
                $quiz->addQuestion($this->getQuestion($questionId));
            }

            $manager->persist($quiz);
            $this->addReference(self::class.':'.$id, $quiz);
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
