<?php

declare(strict_types=1);

namespace App\Tests\ApiPlatform;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\Question;

final class QuestionsTest extends ApiTestCase
{
    /**
     * Route: api_questions_get_item.
     *
     * @example https://127.0.0.1:8006/api/questions/1.jsonld
     */
    public function testGetItem(): void
    {
        $client = static::createClient();
        $client->request('GET', '/api/questions/1');
        self::assertResponseIsSuccessful();
        self::assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        self::assertMatchesResourceItemJsonSchema(Question::class);
        self::assertJsonEquals([
            '@context' => '/api/contexts/Question',
            '@id' => '/api/questions/1',
            '@type' => 'Question',
            'id' => 1,
            'correctAnswerCode' => 'A',
        ]);
    }

    /**
     * @example https://127.0.0.1:8006/api/questions.jsonld
     */
    public function testGetCollection(): void
    {
        $client = static::createClient();
        $client->request('GET', '/api/questions');
        self::assertResponseIsSuccessful();
        self::assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        self::assertMatchesResourceItemJsonSchema(Question::class);
    }
}
