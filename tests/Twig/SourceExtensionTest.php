<?php declare(strict_types=1);

namespace App\Twig\Tests;

use App\Entity\Question;
use App\Repository\QuestionRepository;
use App\Twig\SourceExtension;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class SourceExtensionTest extends KernelTestCase
{
    private QuestionRepository $questionRepository;
    private SourceExtension $sourceExtension;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->sourceExtension = self::$container->get(SourceExtension::class);
        $this->questionRepository = self::$container->get(QuestionRepository::class);
    }

    /**
     * @covers SourceExtension::getSource
     */
    public function testSource(): void
    {
        $question = $this->questionRepository->find(1);
        $source = $this->sourceExtension->getSource($question);
        self::assertContains("namespace \Foo \Bar;", $source);
    }

    /**
     * @covers SourceExtension::getSource
     */
    public function testSourceNotFound(): void
    {
        try {
            $question = new Question();
            $this->sourceExtension->getSource($question);
            self::fail('Calling SourceExtension::getSource() on a question without associated snippet raises an exception.');
        } catch (\Exception $e) {
            self::assertInstanceOf(\InvalidArgumentException::class, $e);
        }
    }
}
