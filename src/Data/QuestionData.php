<?php declare(strict_types=1);

namespace App\Data;

use App\Entity\Question;
use App\Repository\QuestionRepository;
use App\Twig\SourceExtension;
use Doctrine\DBAL\Connection;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class QuestionData
{
    private QuestionRepository $questionRepository;
    private Connection $connection;
    private SourceExtension $sourceExtension;

    public function __construct(QuestionRepository $questionRepository, Connection $connection, SourceExtension $sourceExtension)
    {
        $this->questionRepository = $questionRepository;
        $this->connection = $connection;
        $this->sourceExtension = $sourceExtension;
    }

    public function getQuestion(int $id): Question
    {
        $question = $this->questionRepository->findOneWithNav($id);
        if (!$question instanceof Question) {
            throw new NotFoundHttpException('Question not found!');
        }

        return $question;
    }

    public function count(): int
    {
        return $this->questionRepository->count([]);
    }

    public function getRandomId(): int
    {
        $result = $this->connection->fetchAll('SELECT id FROM question ORDER BY RANDOM() LIMIT 1');
        if (!$result[0]['id']) {
            throw new \UnexpectedValueException('No question found.');
        }

        return (int) $result[0]['id'];
    }

    public function getRandomQuestion(): Question
    {
        $id = $this->getRandomId();

        return $this->getQuestion($id);
    }

    public function getLastId(): int
    {
        $result = $this->connection->fetchAllAssociative('SELECT id FROM question ORDER BY created_at DESC LIMIT 1');
        if (!$result[0]['id']) {
            throw new \UnexpectedValueException('No question found.');
        }

        return (int) $result[0]['id'];
    }

    public function getLastQuestion(): Question
    {
        $id = $this->getLastId();

        return $this->getQuestion($id);
    }

    /**
     * @return array<string,mixed>
     */
    public function getViewParameters(Question $question): array
    {
        return [
            'question' => $question,
            'code' => $this->sourceExtension->getSource($question),
            'count' => $this->count()
        ];
    }

    /**
     * @return array<string,mixed>
     */
    public function getAnswersStats(): array
    {
        $answerCodes = [
            'A' => 0,
            'B' => 0,
            'C' => 0,
            'D' => 0,
        ];

        foreach ($this->questionRepository->findAll() as $question) {
            ++$answerCodes[$question->getCorrectAnswerCode()];
        }

        return [
            'answer_codes' => $answerCodes,
            'total' => array_sum($answerCodes)
        ];
    }
}
