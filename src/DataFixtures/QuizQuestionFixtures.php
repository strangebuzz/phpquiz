<?php declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\QuizQuestion;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class QuizQuestionFixtures extends Fixture implements DependentFixtureInterface
{
    use AppFixturesTrait;

    private const DATA = [
        /*'quiz_id'*/ 1 => [1, 2, 3, 4, 5, 6, 7, 8],
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::DATA as $quizId => $questionsId) {
            $quiz = $this->getQuiz($quizId);

            foreach ($questionsId as $questionId) {
                $question = $this->getQuestion($questionId);
                $quizQuestion = (new QuizQuestion())
                    ->setQuiz($quiz)
                    ->setQuestion($question)
                    ->setRank($questionId);
                $manager->persist($quizQuestion);
            }
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            QuizFixtures::class,
            QuestionFixtures::class,
        ];
    }
}
