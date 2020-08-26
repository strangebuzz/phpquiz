<?php declare(strict_types=1);

namespace App\Data;

use App\Entity\Question;
use App\Repository\QuestionRepository;
use Doctrine\DBAL\Connection;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class QuestionData
{
    private QuestionRepository $questionRepository;
    private Connection $connection;

    public function __construct(QuestionRepository $questionRepository, Connection $connection)
    {
        $this->questionRepository = $questionRepository;
        $this->connection = $connection;
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
        $sql = 'SELECT id FROM question ORDER BY RANDOM() LIMIT 1';
        $id = $this->connection->fetchAll($sql)[0]['id'] ?? null;

        return (int) $id;
    }

    public function getRandomQuestion(): Question
    {
        $id = $this->getRandomId();

        return $this->getQuestion($id);
    }
}
