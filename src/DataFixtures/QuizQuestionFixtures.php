<?php declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\QuizQuestion;
use App\Repository\QuestionRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class QuizQuestionFixtures extends Fixture implements DependentFixtureInterface
{
    use AppFixturesTrait;

    private QuestionRepository $questionRepository;

    private const DATA = [
        /*'quiz_id'*/ 1,
    ];

    public function __construct(QuestionRepository $questionRepository)
    {
        $this->questionRepository = $questionRepository;
    }

    public function load(ObjectManager $manager): void
    {
        foreach (self::DATA as $quizId) {
            $quiz = $this->getQuiz($quizId);
            foreach ($this->questionRepository->findAllByDate() as $idx => $question) {
                $quizQuestion = (new QuizQuestion())
                    ->setQuiz($quiz)
                    ->setQuestion($question)
                    ->setRank($idx+1);
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
