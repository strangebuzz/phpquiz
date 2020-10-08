<?php declare(strict_types=1);

namespace App\Tests\Controller;

use App\DataFixtures\QuizFixtures;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

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
     * @covers QuizController::reset
     */
    public function testReset(): void
    {
        $client = static::createClient();
        $client->request('GET', '/quiz/'.QuizFixtures::UUID.'/retry');
        self::assertResponseRedirects('/quiz/'.QuizFixtures::UUID);
    }
}
