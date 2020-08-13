<?php declare(strict_types=1);

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @covers AppController
 */
class AppControllerTest extends WebTestCase
{
    /**
     * @covers AppController::home
     */
    public function testHome(): void
    {
        $client = static::createClient();
        $client->request('GET', '/');
        self::assertResponseIsSuccessful();
    }

    /**
     * @covers AppController::about
     */
    public function testAbout(): void
    {
        $client = static::createClient();
        $client->request('GET', '/about');
        self::assertResponseIsSuccessful();
    }
}
