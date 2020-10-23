<?php declare(strict_types=1);

namespace App\Tests\Controller;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;

class ApiQuestionsTest extends ApiTestCase
{
    /**
     * Route: api_questions_get_item
     */
    public function testGet(): void
    {
        $client = static::createClient();
        $client->request('GET', '/api/questions/1');
        self::assertResponseIsSuccessful();
        self::assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        self::assertMatchesJsonSchema([
            "@context" => "/api/contexts/Question",
            "@id" => "/api/questions/1",
            "@type" => "Question",
            "id" => 1,
            "correctAnswerCode" => "A"
        ]);
    }
}
