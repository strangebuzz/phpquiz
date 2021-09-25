<?php

declare(strict_types=1);

namespace App\Twig\Tests;

use App\Data\QuestionData;
use App\Twig\QuestionExtension;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class QuestionExtensionTest extends KernelTestCase
{
    private QuestionExtension $questionExtension;
    private QuestionData $questionData;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->questionExtension = static::getContainer()->get(QuestionExtension::class);
        $this->questionData = static::getContainer()->get(QuestionData::class);
    }

    /**
     * @covers QuestionExtension::questionImage
     */
    public function testQuestionImage(): void
    {
        $question = $this->questionData->getQuestion(1);
        self::assertSame('http://localhost/img/questions/1.png', $this->questionExtension->questionImage($question));
    }
}
