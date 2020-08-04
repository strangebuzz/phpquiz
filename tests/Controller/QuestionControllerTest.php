<?php declare(strict_types=1);

namespace App\Controller\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

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
}
