<?php declare(strict_types=1);

namespace App\Controller\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * @covers QuestionController
 */
class QuestionControllerTest extends WebTestCase
{
    /**
     * Route "show".
     *
     * @covers QuestionController::show
     */
    public function testShow(): void
    {
        $client = static::createClient();
        $client->request('GET', '/question/1');
        self::assertResponseIsSuccessful();
        self::assertContains("What will be displayed?", $client->getResponse()->getContent());
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
