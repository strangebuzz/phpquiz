<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use App\DataFixtures\QuizFixtures;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @covers AppController
 */
final class AppControllerTest extends WebTestCase
{
    /**
     * @covers AppController::home
     */
    public function testHome(): void
    {
        $client = self::createClient();
        $client->request('GET', '/');
        self::assertResponseIsSuccessful();
    }

    /**
     * Handling of form, nominal case.
     *
     * @covers AppController::home
     */
    public function testHomeFormNominal(): void
    {
        $client = self::createClient();
        $client->request('GET', '/');
        $client->submitForm('Resume', [
            'quiz_restore[uuid]' => QuizFixtures::UUID,
        ]);
        self::assertResponseRedirects('/quiz/'.QuizFixtures::UUID);
        $client->followRedirect();
        self::assertResponseIsSuccessful();
    }

    /**
     * @return \Generator<int, array>
     */
    public function homeFormErrorsProvider(): \Generator
    {
        yield ['', 'This value should not be blank'];
        yield ['foo', 'This is not a valid UUID'];
        yield ['7424d787-6490-4b95-b489-056c890abbe55', 'This is not a valid UUID'];
        yield ['7424d787-6490-4b95-b489-056c890abbe6', 'Quiz not found'];
    }

    /**
     * Check form errors.
     *
     * @dataProvider homeFormErrorsProvider
     *
     * @covers AppController::home
     */
    public function testHomeFormErrors(string $value, string $error): void
    {
        $client = self::createClient();
        $client->request('GET', '/');
        $client->submitForm('Resume', [
            'quiz_restore[uuid]' => $value,
        ]);
        self::assertResponseIsSuccessful();
        self::assertStringContainsString($error, $client->getResponse()->getContent());
    }

    /**
     * @covers AppController::about
     */
    public function testAbout(): void
    {
        $client = self::createClient();
        $client->request('GET', '/about');
        self::assertResponseIsSuccessful();
    }
}
