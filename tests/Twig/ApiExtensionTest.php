<?php declare(strict_types=1);

namespace App\Twig\Tests;

use App\Entity\Answer;
use App\Entity\Question;
use App\Twig\ApiExtension;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ApiExtensionTest extends KernelTestCase
{
    private ApiExtension $apiExtension;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->apiExtension = self::$container->get(ApiExtension::class);
    }

    /**
     * @covers ApiExtension::serialize
     */
    public function testSerialize(): void
    {
        $question = new Question();
        $answer = (new Answer())
            ->setCode('B')
            ->setCorrect(true);
        $question->addAnswer($answer);
        $json = $this->apiExtension->serialize($question, 'show');
        self::assertJson($json);
        self::assertJsonStringEqualsJsonString('{"id":null,"correctAnswerCode":"B"}', $json);
    }
}
