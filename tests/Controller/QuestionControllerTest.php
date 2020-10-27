<?php declare(strict_types=1);

namespace App\Tests\Controller;

use App\DataFixtures\QuestionFixtures;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * @covers QuestionController
 */
class QuestionControllerTest extends WebTestCase
{
    public function getAnswers(): \Generator
    {
        foreach (range(1, QuestionFixtures::COUNT) as $id) {
            yield [$id];
        }
    }

    /**
     * @covers QuestionController::show
     *
     * @dataProvider getAnswers
     */
    public function testShow(int $questionId): void
    {
        $crawler = static::createClient()->request('GET', '/question/'.$questionId);
        self::assertResponseIsSuccessful();

        // There is four answers for every question (for now)
        self::assertCount(4, $crawler->filter('input[type=radio]'));

        // Test that is is at least one "Read more" link associated to the question
        self::assertTrue(count($crawler->filter('a.read-more')) > 0);
    }

    /**
     * @covers QuestionController::show
     */
    public function testShowNotFOund(): void
    {
        $client = static::createClient();
        $client->request('GET', '/question/notfound');
        self::assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);

        $client->request('GET', '/question/4465465');
        self::assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }

    /**
     * @covers QuestionController::random
     */
    public function testRandom(): void
    {
        $client = static::createClient();
        $client->request('GET', '/question/random');
        self::assertResponseIsSuccessful();
    }

    /**
     * @covers QuestionController::last
     */
    public function testLast(): void
    {
        $client = static::createClient();
        $client->request('GET', '/question/last');
        self::assertResponseIsSuccessful();
    }
}
