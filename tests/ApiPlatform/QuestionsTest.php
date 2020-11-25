<?php

declare(strict_types=1);

namespace App\Tests\ApiPlatform;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\Question;

class QuestionsTest extends ApiTestCase
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
        /*  bug APIP/PHPUnit 🐞
        declaration of ApiPlatform\Core\Bridge\Symfony\Bundle\Test\Constraint\ArraySubset::evaluate($other, string $description = '', bool $returnResult = false): ?bool should be compatible with PHPUnit\Framework\Constraint\Constraint::evaluate($other, $description = '', $returnResult = false)
        self::assertJsonContains([
            '@context' => '/api/contexts/Question',
            '@id' => '/api/questions',
            '@type' => 'hydra:Collection',
        ]);
        */
    }
}
