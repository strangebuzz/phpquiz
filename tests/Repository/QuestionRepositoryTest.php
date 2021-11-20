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
final class QuestionRepositoryTest extends KernelTestCase
{
    private QuestionRepository $repo;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->repo = static::getContainer()->get(QuestionRepository::class);
    }

    /**
     * @covers QuestionRepository::findOneWithNav
     *
     * @see QuestionFixtures
     */
    public function testFindOneWithNav(): void
    {
        $question = $this->repo->findOneWithNav(2);
        self::assertInstanceOf(Question::class, $question);
        if (!$question instanceof Question) {
            throw new \RuntimeException('Test question not found.');
        }
        self::assertInstanceOf(Question::class, $question);
        self::assertInstanceOf(Question::class, $question->getPreviousQuestion());
        self::assertInstanceOf(Question::class, $question->getNextQuestion());
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
