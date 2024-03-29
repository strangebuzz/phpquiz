<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * @covers QuestionController
 */
final class QuestionControllerTest extends WebTestCase
{
    /**
     * @return iterable<int, array{0: int}>
     */
    public function getAnswers(): iterable
    {
        foreach (range(1, 27) as $id) {
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
        $crawler = self::createClient()->request('GET', '/question/'.$questionId);
        self::assertResponseIsSuccessful();

        // There is four answers for every question (for now)
        self::assertCount(4, $crawler->filter('input[type=radio]'));

        // Test that is is at least one "Read more" link associated to the question
        self::assertNotEmpty($crawler->filter('a.read-more'));
    }

    /**
     * @covers QuestionController::show
     */
    public function testShowNotFOund(): void
    {
        $client = self::createClient();
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
        $client = self::createClient();
        $client->request('GET', '/question/random');
        self::assertResponseIsSuccessful();
    }

    /**
     * @covers QuestionController::last
     */
    public function testLast(): void
    {
        $client = self::createClient();
        $client->request('GET', '/question/last');
        self::assertResponseIsSuccessful();
    }
}
