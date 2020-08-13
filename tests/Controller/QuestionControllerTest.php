<?php declare(strict_types=1);

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * @covers QuestionController
 */
class QuestionControllerTest extends WebTestCase
{
    public function getAnswers(): array
    {
        return [
            [1],
            [2],
            [3],
        ];
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
        $client->request('GET', '/question/'.$questionId);
        self::assertResponseIsSuccessful();
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
    }
}
