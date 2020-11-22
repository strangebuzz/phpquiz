<?php

declare(strict_types=1);

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase as BaseWebTestCase;

class WebTestCase extends BaseWebTestCase
{
    /**
     * Get the question count thanks to the
     */
    public function getQuestionCount(KernelBrowser $client): int
    {
        $client->request('GET', '/api/questions', [], [], ['HTTP_ACCEPT' => 'application/ld+json']);
        $data = json_decode((string) $client->getResponse()->getContent(), true, 512, JSON_THROW_ON_ERROR);

        return (int) ($data['hydra:totalItems'] ?? 0);
    }
}
