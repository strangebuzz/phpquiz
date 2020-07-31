<?php declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Answer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AnswerFixtures extends Fixture
{
    private const DATA = [
        [
            /*'quiz_id' =>*/ 1,
            /*'label'   =>*/ "Fatal error: Uncaught Error: Undefined constant 'Foo\Bar'",
            /*'correct' =>*/ true,
        ]
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::DATA as [$quizId, $label, $correct]) {

            $question = (new Answer())
                ->setLabel($label)
                ->setCorrect((bool) $correct)
                ;

            $manager->persist($question);
        }
        $manager->flush();
    }
}
