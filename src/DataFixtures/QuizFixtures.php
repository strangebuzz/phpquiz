<?php declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Quiz;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Yaml\Yaml;

class QuizFixtures extends Fixture
{
    use AppFixturesTrait;

    public const UUID = '1d8bd99d-088d-473d-bf0c-0da4bce79075'; // for tests

    public function load(ObjectManager $manager): void
    {
        foreach ($this->loadYaml(self::class)['quiz'] as $quizArr) {
            [$id, $uuid] = array_values($quizArr);
            $quiz = (new Quiz())->setUuid((string) $uuid);
            $manager->persist($quiz);
            $this->addReference(self::class.$id, $quiz);
        }

        $manager->flush();
    }
}
