<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use App\DataFixtures\QuizFixtures;
use App\Tests\WebTestCase;
use Symfony\Component\Config\Definition\Exception\InvalidTypeException;
use Symfony\Component\DomCrawler\Field\ChoiceFormField;

/**
 * @covers QuizController
 */
class QuizControllerTest extends WebTestCase
{
    /**
     * @covers QuizController::new
     */
    public function testNew(): void
    {
        $client = static::createClient();
        $client->request('GET', '/quiz/new');
        self::assertResponseRedirects();
    }

    /**
     * @covers QuizController::question
     */
    public function testQuestion(): void
    {
        $client = static::createClient();
        $client->request('GET', '/quiz/'.QuizFixtures::UUID);
        self::assertResponseIsSuccessful();
    }

    /**
     * @covers QuizController::result
     */
    public function testResult(): void
    {
        $client = static::createClient();

        // Can't get score of non finished quiz, redirected to the question
        $client->request('GET', '/quiz/'.QuizFixtures::UUID.'/result');
        self::assertResponseRedirects('/quiz/'.QuizFixtures::UUID);
    }

    /**
     * @covers QuizController::retry
     */
    public function testRetry(): void
    {
        $client = static::createClient();
        $client->request('GET', '/quiz/'.QuizFixtures::UUID.'/retry');
        self::assertResponseRedirects('/quiz/'.QuizFixtures::UUID);
    }

    /**
     * Test to whole quiz and anwer all questions with A, B, C and D. These tests
     * have to use a separte process because they can mess up the memory and raise
     * unexepcted warnings.
     *
     * @covers QuizController::question
     * @covers QuizController::result
     *
     * @runInSeparateProcess
     */
    public function testQuestionSubmit(): void
    {
        $client = static::createClient();
        $questionCount = $this->getQuestionCount($client);

        $client->request('GET', '/quiz/new');
        $client->followRedirect();
        self::assertContains(sprintf('Question 1/%d', $questionCount), $client->getResponse()->getContent());

        foreach (range(1, $questionCount) as $questionRank) {
            $form = $client->getCrawler()->selectButton('Submit')->form();
            $answerFormField = $form['quiz[answer]'];
            if (!$answerFormField instanceof ChoiceFormField) {
                throw new InvalidTypeException('Type check.');
            }

            // Select a random answer
            $answerFormField->select($answerFormField->availableOptionValues()[mt_rand(0, 3)]);
            $client->submit($form);
            $client->followRedirect();

            // Results or next question page
            if ($questionRank === $questionCount) {
                $client->followRedirect();
                self::assertContains('Your score:', $client->getResponse()->getContent());
            } else {
                self::assertContains(sprintf('Question %d/%d', $questionRank + 1, $questionCount), $client->getResponse()->getContent());
            }
        }
    }
}
