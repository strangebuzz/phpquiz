<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use App\DataFixtures\QuizFixtures;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Config\Definition\Exception\InvalidTypeException;
use Symfony\Component\DomCrawler\Field\ChoiceFormField;

/**
 * @covers \QuizController
 */
class QuizControllerTest extends WebTestCase
{
    public const COUNT = 24; // Change me after each fixtures update

    /**
     * @covers \QuizController::new
     */
    public function testNew(): void
    {
        $client = static::createClient();
        $client->request('GET', '/quiz/new');
        self::assertResponseRedirects();
    }

    /**
     * @covers \QuizController::question
     */
    public function testQuestion(): void
    {
        $client = static::createClient();
        $client->request('GET', '/quiz/'.QuizFixtures::UUID);
        self::assertResponseIsSuccessful();
    }

    /**
     * @covers \QuizController::result
     */
    public function testResult(): void
    {
        $client = static::createClient();

        // Can't get score of non finished quiz, redirected to the question
        $client->request('GET', '/quiz/'.QuizFixtures::UUID.'/result');
        self::assertResponseRedirects('/quiz/'.QuizFixtures::UUID);
    }

    /**
     * @covers \QuizController::retry
     */
    public function testRetry(): void
    {
        $client = static::createClient();
        $client->request('GET', '/quiz/'.QuizFixtures::UUID.'/retry');
        self::assertResponseRedirects('/quiz/'.QuizFixtures::UUID);
    }

    /**
     * Test to whole quiz and anwer all questions with "A". Modify the $scoreWithA
     * varaible after each new question which correct answer is "A".
     *
     * @covers \QuizController::result
     *
     * @return array<int, array>
     */
    public function questionSubmitDataProvider(): array
    {
        return [
            ['A', 7], // Answer code => number of correction answers for this code
            ['B', 4],
            ['C', 9],
            ['D', 4],
        ];
    }

    /**
     * Test to whole quiz and anwer all questions with A, B, C and D. These tests
     * have to use a separte process because they can mess up the memory and raise
     * unexepcted warnings.
     *
     * @covers \QuizController::question
     * @covers \QuizController::result
     *
     * @dataProvider questionSubmitDataProvider
     * @runInSeparateProcess
     */
    public function testQuestionSubmit(string $answserCode, int $score): void
    {
        $questionsCount = self::COUNT;
        $client = static::createClient();
        $client->request('GET', '/quiz/new');
        $client->followRedirect();
        self::assertContains(sprintf('Question 1/%d', $questionsCount), $client->getResponse()->getContent());

        foreach (range(1, $questionsCount) as $questionRank) {
            $form = $client->getCrawler()->selectButton('Submit')->form();
            $answerFormField = $form['quiz[answer]'];
            if (!$answerFormField instanceof ChoiceFormField) {
                throw new InvalidTypeException('Type check.');
            }

            // Select 1st option available, it's always "A".
            $answerFormField->select($answerFormField->availableOptionValues()[ord($answserCode) - 65]); // "A" ord is 65. "B" is 66...
            $client->submit($form);
            $client->followRedirect();
            // Results or question page
            if ($questionRank === $questionsCount) {
                $client->followRedirect();
                self::assertContains(sprintf('Your score: %d/%d', $score, $questionsCount), $client->getResponse()->getContent());
            } else {
                self::assertContains(sprintf('Question %d/%d', $questionRank + 1, $questionsCount), $client->getResponse()->getContent());
            }
        }
    }

    /**
     * Check that we have the same number of answer that.
     */
    public function testQuestionsCount(): void
    {
        self::assertSame(self::COUNT, array_sum(array_column($this->questionSubmitDataProvider(), 1)));
    }
}
