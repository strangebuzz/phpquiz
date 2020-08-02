<?php declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Answer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AnswerFixtures extends Fixture implements DependentFixtureInterface
{
    use AppFixturesTrait;

    private const DATA = [
        [
            /*'question_id' =>*/ 1,
            /*'code'        =>*/ 'A',
            /*'label'       =>*/ "Fatal error: Uncaught Error: Undefined constant 'Foo\Bar'",
            /*'correct'     =>*/ true,
        ],
        [
            /*'question_id' =>*/ 1,
            /*'code'        =>*/ 'B',
            /*'label'       =>*/ "Parse error: syntax error, unexpected '\' (T_NS_SEPARATOR)'",
            /*'correct'     =>*/ false,
        ],
        [
            /*'question_id' =>*/ 1,
            /*'code'        =>*/ 'C',
            /*'label'       =>*/ "Foo\Bar\A",
            /*'correct'     =>*/ false,
        ],
        [
            /*'question_id' =>*/ 1,
            /*'code'        =>*/ 'D',
            /*'label'       =>*/ "Foo\Bar\B",
            /*'correct'     =>*/ false,
        ],
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::DATA as [$questionId, $code, $label, $correct]) {
            $question = $this->getQuestion($questionId);
            $answer = (new Answer())
                ->setCode($code)
                ->setLabel($label)
                ->setQuestion($question)
                ->setCorrect((bool) $correct);

            $manager->persist($answer);
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
