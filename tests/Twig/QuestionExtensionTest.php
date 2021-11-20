<?php

declare(strict_types=1);

namespace App\Twig\Tests;

use App\Data\QuestionData;
use App\Twig\QuestionExtension;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class QuestionExtensionTest extends KernelTestCase
{
    private QuestionExtension $questionExtension;
    private QuestionData $questionData;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->questionExtension = self::getContainer()->get(QuestionExtension::class);
        $this->questionData = self::getContainer()->get(QuestionData::class);
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
