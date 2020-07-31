<?php declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Answer;
use App\Entity\Question;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Config\Definition\Exception\InvalidTypeException;

class AnswerFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * @var array<int,Question>
     */
    private array $questions = [];

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

    public function getDependencies(): array
    {
        return [
            QuestionFixtures::class,
        ];
    }
}
