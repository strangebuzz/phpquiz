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
        /*'question_id'*/ 11 => [
            [
                /*'code'        =>*/ 'A',
                /*'label'       =>*/ '__invoke',
                /*'correct'     =>*/ false,
                /*'poll_result' =>*/ 2220,
            ],
            [
                /*'code'        =>*/ 'B',
                /*'label'       =>*/ 'Foo\Bar',
                /*'correct'     =>*/ false,
                /*'poll_result' =>*/ 1110,
            ],
            [
                /*'code'        =>*/ 'C',
                /*'label'       =>*/ 'Fatal error: Uncaught Error: Function name must be a string',
                /*'correct'     =>*/ false,
                /*'poll_result' =>*/ 2590,
            ],
            [
                /*'code'        =>*/ 'D',
                /*'label'       =>*/ 'Fatal error: Uncaught Error: Object of type Foo\Bar is not callable',
                /*'correct'     =>*/ true,
                /*'poll_result' =>*/ 4070,
            ],
        ],
        /*'question_id'*/ 12 => [
            [
                /*'code'        =>*/ 'A',
                /*'label'       =>*/ 'int(3)',
                /*'correct'     =>*/ true,
                /*'poll_result' =>*/ 2290,
            ],
            [
                /*'code'        =>*/ 'B',
                /*'label'       =>*/ 'int(0)',
                /*'correct'     =>*/ false,
                /*'poll_result' =>*/ 8600,
            ],
            [
                /*'code'        =>*/ 'C',
                /*'label'       =>*/ 'Fatal error: Uncaught TypeError: Foo::__set(): Argument #2 ($value) must be of type int, string given',
                /*'correct'     =>*/ false,
                /*'poll_result' =>*/ 5430,
            ],
            [
                /*'code'        =>*/ 'D',
                /*'label'       =>*/ 'Fatal error: Uncaught Error: Cannot access undefined property Foo::$x',
                /*'correct'     =>*/ false,
                /*'poll_result' =>*/ 0,
            ],
        ],
        /*'question_id'*/ 13 => [
            [
                /*'code'        =>*/ 'A',
                /*'label'       =>*/ 'string(1) "B"',
                /*'correct'     =>*/ true,
                /*'poll_result' =>*/ 5330,
            ],
            [
                /*'code'        =>*/ 'B',
                /*'label'       =>*/ 'Fatal error: Declaration of B::foo(): B must be compatible with A::foo(): A',
                /*'correct'     =>*/ false,
                /*'poll_result' =>*/ 1000,
            ],
            [
                /*'code'        =>*/ 'C',
                /*'label'       =>*/ "Parse error: syntax error, unexpected 'static'",
                /*'correct'     =>*/ false,
                /*'poll_result' =>*/ 1670,
            ],
            [
                /*'code'        =>*/ 'D',
                /*'label'       =>*/ 'Fatal error: Cannot use ::class with dynamic class name',
                /*'correct'     =>*/ false,
                /*'poll_result' =>*/ 2000,
            ],
        ],
        /*'question_id'*/ 14 => [
            [
                /*'code'        =>*/ 'A',
                /*'label'       =>*/ 'bar / bar',
                /*'correct'     =>*/ false,
                /*'poll_result' =>*/ 2730,
            ],
            [
                /*'code'        =>*/ 'B',
                /*'label'       =>*/ 'foo->bar() / bar ',
                /*'correct'     =>*/ false,
                /*'poll_result' =>*/ 4240,
            ],
            [
                /*'code'        =>*/ 'C',
                /*'label'       =>*/ "() / bar",
                /*'correct'     =>*/ true,
                /*'poll_result' =>*/ 1520,
            ],
            [
                /*'code'        =>*/ 'D',
                /*'label'       =>*/ 'Parse error',
                /*'correct'     =>*/ false,
                /*'poll_result' =>*/ 1520,
            ],
        ],
        /*'question_id'*/ 15 => [
            [
                /*'code'        =>*/ 'A',
                /*'label'       =>*/ 'Fatal error: Uncaught TypeError',
                /*'correct'     =>*/ false,
                /*'poll_result' =>*/ 230,
            ],
            [
                /*'code'        =>*/ 'B',
                /*'label'       =>*/ 'Fatal error: Uncaught Error: Cannot access private property',
                /*'correct'     =>*/ false,
                /*'poll_result' =>*/ 680,
            ],
            [
                /*'code'        =>*/ 'C',
                /*'label'       =>*/ 'Fatal error: Uncaught Error: Using $this when not in object context',
                /*'correct'     =>*/ true,
                /*'poll_result' =>*/ 5450,
            ],
            [
                /*'code'        =>*/ 'D',
                /*'label'       =>*/ 'bar',
                /*'correct'     =>*/ false,
                /*'poll_result' =>*/ 3640,
            ]
        ],
        /*'question_id'*/ 16 => [
            [
                /*'code'        =>*/ 'A',
                /*'label'       =>*/ 'end',
                /*'correct'     =>*/ false,
                /*'poll_result' =>*/ 2960,
            ],
            [
                /*'code'        =>*/ 'B',
                /*'label'       =>*/ 'fooend',
                /*'correct'     =>*/ true,
                /*'poll_result' =>*/ 4070,
            ],
            [
                /*'code'        =>*/ 'C',
                /*'label'       =>*/ 'foofooend',
                /*'correct'     =>*/ false,
                /*'poll_result' =>*/ 930,
            ],
            [
                /*'code'        =>*/ 'D',
                /*'label'       =>*/ 'Parse Error',
                /*'correct'     =>*/ false,
                /*'poll_result' =>*/ 2040,
            ]
        ],
        /*'question_id'*/ 17 => [
            [
                /*'code'        =>*/ 'A',
                /*'label'       =>*/ 'Notice + NULL',
                /*'correct'     =>*/ false,
                /*'poll_result' =>*/ 1800,
            ],
            [
                /*'code'        =>*/ 'B',
                /*'label'       =>*/ 'int(5)',
                /*'correct'     =>*/ false,
                /*'poll_result' =>*/ 600,
            ],
            [
                /*'code'        =>*/ 'C',
                /*'label'       =>*/ 'string(1) "5"',
                /*'correct'     =>*/ false,
                /*'poll_result' =>*/ 2000,
            ],
            [
                /*'code'        =>*/ 'D',
                /*'label'       =>*/ 'Fatal TypeError',
                /*'correct'     =>*/ true,
                /*'poll_result' =>*/ 5600,
            ]
        ],
        /*'question_id'*/ 18 => [
            [
                /*'code'        =>*/ 'A',
                /*'label'       =>*/ '[10][20]',
                /*'correct'     =>*/ false,
                /*'poll_result' =>*/ 2390,
            ],
            [
                /*'code'        =>*/ 'B',
                /*'label'       =>*/ '[10][2]',
                /*'correct'     =>*/ false,
                /*'poll_result' =>*/ 2830,
            ],
            [
                /*'code'        =>*/ 'C',
                /*'label'       =>*/ '[10] TypeError',
                /*'correct'     =>*/ true,
                /*'poll_result' =>*/ 3700,
            ],
            [
                /*'code'        =>*/ 'D',
                /*'label'       =>*/ 'ParseError',
                /*'correct'     =>*/ false,
                /*'poll_result' =>*/ 1090,
            ]
        ],
    ];

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
