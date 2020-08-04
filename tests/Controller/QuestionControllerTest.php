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
     * @covers QuestionController::show
     */
    public function testShow(): void
    {
        $client = static::createClient();
        $client->request('GET', '/question/1');
        self::assertResponseIsSuccessful();
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
