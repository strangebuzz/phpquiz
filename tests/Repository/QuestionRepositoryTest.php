<?php

declare(strict_types=1);

namespace App\Tests\Repository;

use App\DataFixtures\QuestionFixtures;
use App\Entity\Question;
use App\Repository\QuestionRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * @covers QuestionRepository
 */
class QuestionRepositoryTest extends KernelTestCase
{
    private QuestionRepository $repo;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->repo = self::$container->get(QuestionRepository::class);
    }

    /**
     * @covers QuestionRepository::findAllByDate
     * @covers AnswerFixtures::load
     */
    public function testFindAllByDate(): void
    {
        foreach ($this->repo->findAllByDate() as $question) {
            self::assertInstanceOf(Question::class, $question);

            if (!$question instanceof Question) {
                throw new \InvalidArgumentException('Wrong type! (IDE)');
            }
            // Check that every question has a single correct answer.
            $question->getCorrectAnswerCode();
        }
    }
}
