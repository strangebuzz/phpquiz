<?php declare(strict_types=1);

namespace App\Tests\ApiPlatform;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\Question;

class QuestionsTest extends ApiTestCase
{
    /**
     * Route: api_questions_get_item
     */
    public function testGet(): void
    {
        $client = static::createClient();
        $client->request('GET', '/api/questions/1');
        self::assertResponseIsSuccessful();
        /** @noinspection PhpInternalEntityUsedInspection */
        $response = $client->getResponse();
        self::assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        self::assertJson($response->getContent());
        self::assertMatchesResourceItemJsonSchema(Question::class);
        $json = <<<EOT
{ 
  "@context": "/api/contexts/Question",
  "@id": "/api/questions/1",
  "@type": "Question",
  "id": 1,
  "correctAnswerCode": "A"
}
EOT;
        self::assertJsonStringEqualsJsonString($json, $response->getContent());
    }
}
