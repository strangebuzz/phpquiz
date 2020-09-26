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
        foreach (range(1, count(QuestionFixtures::DATA)) as $id) {
            yield [$id];
        }
    }

    /**
     * Route "show".
     *
     * @covers QuestionController::show
     *
     * @dataProvider getAnswers
     */
    public function testShow(int $questionId): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/question/'.$questionId);
        self::assertResponseIsSuccessful();

        // Test that is is at least one "Read more" link associated to the question
        self::assertTrue(count($crawler->filter('a.read-more')) > 0);
    }

    /**
     * Route "show_json".
     *
     * @covers QuestionController::show
     */
    public function testShowJson(): void
    {
        $client = static::createClient();
        $client->request('GET', '/question/1.json');
        $json = $client->getResponse()->getContent();
        self::assertResponseIsSuccessful();
        self::assertJson($json);
        self::assertJsonStringEqualsJsonString('{"id":1,"correctAnswerCode":"A"}', $json);
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
