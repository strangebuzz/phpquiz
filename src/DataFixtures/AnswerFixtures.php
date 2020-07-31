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
    private const DATA = [
        [
            /*'question_id' =>*/ 1,
            /*'label'       =>*/ "Fatal error: Uncaught Error: Undefined constant 'Foo\Bar'",
            /*'correct'     =>*/ true,
        ],
        [
            /*'question_id' =>*/ 1,
            /*'label'       =>*/ "Parse error: syntax error, unexpected '\' (T_NS_SEPARATOR)'",
            /*'correct'     =>*/ false,
        ],
        [
            /*'question_id' =>*/ 1,
            /*'label'       =>*/ "Foo\Bar\A",
            /*'correct'     =>*/ false,
        ],
        [
            /*'question_id' =>*/ 1,
            /*'label'       =>*/ "Foo\Bar\B",
            /*'correct'     =>*/ false,
        ],
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::DATA as [$questionId, $label, $correct]) {
            $question = $this->getQuestion($questionId);
            $answer = (new Answer())
                ->setLabel($label)
                ->setQuestion($question)
                ->setCorrect((bool) $correct);

            $manager->persist($answer);
        }
        $manager->flush();
    }

    private function getQuestion(int $id): Question
    {
        $article = $this->getReference(QuestionFixtures::class.$id);
        if (!$article instanceof Question) {
            throw new InvalidTypeException(sprintf('Question "%d" not found.', $id));
        }

        return $article;
    }

    public function getDependencies(): array
    {
        return [
            QuestionFixtures::class,
        ];
    }
}
