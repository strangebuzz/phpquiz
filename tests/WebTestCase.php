<?php

declare(strict_types=1);

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase as BaseWebTestCase;

class WebTestCase extends BaseWebTestCase
{
    /**
     * Get the question count thanks to API plarform.
     */
    public function getQuestionCount(KernelBrowser $client): int
    {
        $client->request('GET', '/api/questions.jsonld');
        /** @var array<string, int> $data */
        $data = json_decode((string) $client->getResponse()->getContent(), true, 512, JSON_THROW_ON_ERROR);

        if (!\array_key_exists('hydra:totalItems', $data)) {
            throw new \RuntimeException("Can't find the totalItems hydra field.");
        }

        return (int) $data['hydra:totalItems'];
    }
}
