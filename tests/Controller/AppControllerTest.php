<?php declare(strict_types=1);

namespace App\Controller\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @covers AppController
 */
class AppControllerTest extends WebTestCase
{
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
