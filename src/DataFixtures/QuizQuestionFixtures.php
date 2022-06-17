<?php

declare(strict_types=1);

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

    public function __construct(QuestionRepository $questionRepository)
    {
        $this->questionRepository = $questionRepository;
    }

    /**
     * YAML loader is not really necessary but it's to keep consistency with other ones.
     */
    public function load(ObjectManager $manager): void
    {
        $quizQuestions = $this->loadYaml(self::class)['quiz_questions'];
        foreach ($quizQuestions as $quizQuestionArr) {
            $quiz = $this->getQuiz($quizQuestionArr['quiz_id']);
            foreach ($this->questionRepository->findAllByDate() as $idx => $question) {
                $quizQuestion = (new QuizQuestion())
                    ->setQuiz($quiz)
                    ->setQuestion($question)
                    ->setRank($idx + 1);
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
