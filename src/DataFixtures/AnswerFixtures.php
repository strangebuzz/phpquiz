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
        /*'question_id'*/ 1 => [
            [
                /*'code'        =>*/ 'A',
                /*'label'       =>*/ "Fatal error: Uncaught Error: Undefined constant 'Foo\Bar'",
                /*'correct'     =>*/ true,
                /*'poll_result' =>*/ 1250,
            ],
            [
                /*'code'        =>*/ 'B',
                /*'label'       =>*/ "Parse error: syntax error, unexpected '\' (T_NS_SEPARATOR)'",
                /*'correct'     =>*/ false,
                /*'poll_result' =>*/ 3750,
            ],
            [
                /*'code'        =>*/ 'C',
                /*'label'       =>*/ "Foo\Bar\A",
                /*'correct'     =>*/ false,
                /*'poll_result' =>*/ 1750,
            ],
            [
                /*'code'        =>*/ 'D',
                /*'label'       =>*/ "Foo\Bar\B",
                /*'correct'     =>*/  false,
                /*'poll_result' =>*/ 3250,
            ],
        ],
        /*'question_id'*/ 2 => [
            [
                /*'code'        =>*/ 'A',
                /*'label'       =>*/ '42',
                /*'correct'     =>*/ false,
                /*'poll_result' =>*/ 4260,
            ],
            [
                /*'code'        =>*/ 'B',
                /*'label'       =>*/ '24',
                /*'correct'     =>*/ false,
                /*'poll_result' =>*/ 1300,
            ],
            [
                /*'code'        =>*/ 'C',
                /*'label'       =>*/ "Parse error: syntax error, unexpected '...' (T_ELLIPSIS)",
                /*'correct'     =>*/ false,
                /*'poll_result' =>*/ 1480,
            ],
            [
                /*'code'        =>*/ 'D',
                /*'label'       =>*/ 'Fatal error: Uncaught Error: Cannot unpack Traversable with string keys',
                /*'correct'     =>*/ true,
                /*'poll_result' =>*/ 2960,
            ],
        ],
        /*'question_id'*/ 3 => [
            [
                /*'code'        =>*/ 'A',
                /*'label'       =>*/ 'int(42)',
                /*'correct'     =>*/ false,
                /*'poll_result' =>*/ 6250,
            ],
            [
                /*'code'        =>*/ 'B',
                /*'label'       =>*/ 'NULL',
                /*'correct'     =>*/ false,
                /*'poll_result' =>*/ 1880,
            ],
            [
                /*'code'        =>*/ 'C',
                /*'label'       =>*/ "Fatal error: Uncaught Error: Cannot access private property B::\$foo",
                /*'correct'     =>*/ true,
                /*'poll_result' =>*/ 1560,
            ],
            [
                /*'code'        =>*/ 'D',
                /*'label'       =>*/ "Parse error: syntax error, unexpected '{'",
                /*'correct'     =>*/ false,
                /*'poll_result' =>*/ 310,
            ],
        ],
        /*'question_id'*/ 4 => [
            [
                /*'code'        =>*/ 'A',
                /*'label'       =>*/ '[nothing]',
                /*'correct'     =>*/ true,
                /*'poll_result' =>*/ 1960,
            ],
            [
                /*'code'        =>*/ 'B',
                /*'label'       =>*/ 'int(42)',
                /*'correct'     =>*/ false,
                /*'poll_result' =>*/ 1740,
            ],
            [
                /*'code'        =>*/ 'C',
                /*'label'       =>*/ "string(2) 42",
                /*'correct'     =>*/ false,
                /*'poll_result' =>*/ 870,
            ],
            [
                /*'code'        =>*/ 'D',
                /*'label'       =>*/ "Fatal Error (type error)",
                /*'correct'     =>*/ false,
                /*'poll_result' =>*/ 5430,
            ],
        ],
        /*'question_id'*/ 5 => [
            [
                /*'code'        =>*/ 'A',
                /*'label'       =>*/ 'null',
                /*'correct'     =>*/ false,
                /*'poll_result' =>*/ 5200,
            ],
            [
                /*'code'        =>*/ 'B',
                /*'label'       =>*/ 'a',
                /*'correct'     =>*/ false,
                /*'poll_result' =>*/ 3070,
            ],
            [
                /*'code'        =>*/ 'C',
                /*'label'       =>*/ "42",
                /*'correct'     =>*/ true,
                /*'poll_result' =>*/ 1070,
            ],
            [
                /*'code'        =>*/ 'D',
                /*'label'       =>*/ "[nothing]",
                /*'correct'     =>*/ false,
                /*'poll_result' =>*/ 670,
            ],
        ],
        /*'question_id'*/ 6 => [
            [
                /*'code'        =>*/ 'A',
                /*'label'       =>*/ 'foo',
                /*'correct'     =>*/ true,
                /*'poll_result' =>*/ 2830,
            ],
            [
                /*'code'        =>*/ 'B',
                /*'label'       =>*/ 'Fatal error: Uncaught TypeError: Cannot use "::class" on function name',
                /*'correct'     =>*/ false,
                /*'poll_result' =>*/ 2670,
            ],
            [
                /*'code'        =>*/ 'C',
                /*'label'       =>*/ "Fatal error: Uncaught Error: Call to undefined function ()",
                /*'correct'     =>*/ false,
                /*'poll_result' =>*/ 1500,
            ],
            [
                /*'code'        =>*/ 'D',
                /*'label'       =>*/ 'Parse error: syntax error, unexpected token "::"',
                /*'correct'     =>*/ false,
                /*'poll_result' =>*/ 3000,
            ],
        ],
        /*'question_id'*/ 7 => [
            [
                /*'code'        =>*/ 'A',
                /*'label'       =>*/ 'Fatal error: Uncaught Error: Call to undefined function Foo\Bar()',
                /*'correct'     =>*/ false,
                /*'poll_result' =>*/ 4750,
            ],
            [
                /*'code'        =>*/ 'B',
                /*'label'       =>*/ 'Fatal error: Cannot declare Foo\bar() because the name is already in use',
                /*'correct'     =>*/ false,
                /*'poll_result' =>*/ 1630,
            ],
            [
                /*'code'        =>*/ 'C',
                /*'label'       =>*/ "BAR",
                /*'correct'     =>*/ true,
                /*'poll_result' =>*/ 2130,
            ],
            [
                /*'code'        =>*/ 'D',
                /*'label'       =>*/ 'BARBAR',
                /*'correct'     =>*/ false,
                /*'poll_result' =>*/ 1500,
            ],
        ],
        /*'question_id'*/ 8 => [
            [
                /*'code'        =>*/ 'A',
                /*'label'       =>*/ 'int(42)',
                /*'correct'     =>*/ false,
                /*'poll_result' =>*/ 3410,
            ],
            [
                /*'code'        =>*/ 'B',
                /*'label'       =>*/ 'Fatal error: Abstract function T::get() cannot be declared private',
                /*'correct'     =>*/ true,
                /*'poll_result' =>*/ 3410,
            ],
            [
                /*'code'        =>*/ 'C',
                /*'label'       =>*/ "Fatal error: Abstract function T::get() cannot be declared in trait",
                /*'correct'     =>*/ false,
                /*'poll_result' =>*/ 2200,
            ],
            [
                /*'code'        =>*/ 'D',
                /*'label'       =>*/ 'Obi Wan Kenobi',
                /*'correct'     =>*/ false,
                /*'poll_result' =>*/ 980,
            ],
        ],
        /*'question_id'*/ 9 => [
            [
                /*'code'        =>*/ 'A',
                /*'label'       =>*/ 'not numeric: 0, not numeric: 1337',
                /*'correct'     =>*/ false,
                /*'poll_result' =>*/ 3330,
            ],
            [
                /*'code'        =>*/ 'B',
                /*'label'       =>*/ 'not numeric: 0, numeric: 1337',
                /*'correct'     =>*/ false,
                /*'poll_result' =>*/ 2330,
            ],
            [
                /*'code'        =>*/ 'C',
                /*'label'       =>*/ "numeric: 42, not numeric: 1337",
                /*'correct'     =>*/ true,
                /*'poll_result' =>*/ 1000,
            ],
            [
                /*'code'        =>*/ 'D',
                /*'label'       =>*/ 'numeric: 42, numeric: 1337',
                /*'correct'     =>*/ false,
                /*'poll_result' =>*/ 3330,
            ],
        ],
        /*'question_id'*/ 10 => [
            [
                /*'code'        =>*/ 'A',
                /*'label'       =>*/ 'string, string',
                /*'correct'     =>*/ false,
                /*'poll_result' =>*/ 3730,
            ],
            [
                /*'code'        =>*/ 'B',
                /*'label'       =>*/ 'string, array',
                /*'correct'     =>*/ false,
                /*'poll_result' =>*/ 2060,
            ],
            [
                /*'code'        =>*/ 'C',
                /*'label'       =>*/ "Fatal error: Method Foo::__call() must take exactly 2 arguments",
                /*'correct'     =>*/ true,
                /*'poll_result' =>*/ 2750,
            ],
            [
                /*'code'        =>*/ 'D',
                /*'label'       =>*/ 'Fatal error: A void function must not return a value',
                /*'correct'     =>*/ false,
                /*'poll_result' =>*/ 1470,
            ],
        ],
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::DATA as $questionId => $questions) {
            $question = $this->getQuestion($questionId);
            foreach ($questions as [$code, $label, $correct, $pollResult]) {
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
