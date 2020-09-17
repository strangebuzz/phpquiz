<?php declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Quiz;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class QuizFixtures extends Fixture
{
    use AppFixturesTrait;

    public const UUID = '1d8bd99d-088d-473d-bf0c-0da4bce79075';

    /**
     * @see QuizControllerTest
     */
    public const DATA = [
        [
            /*'id'   => */ 1,
            /*'uuid' => */ self::UUID,
        ],
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::DATA as [$id, $uuid]) {
            $quiz = (new Quiz())->setUuid((string) $uuid);
            $manager->persist($quiz);
            $this->addReference(self::class.$id, $quiz);
        }

        $manager->flush();
    }
}
