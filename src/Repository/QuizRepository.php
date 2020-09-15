<?php declare(strict_types=1);

namespace App\Repository;

use App\Entity\Quiz;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Quiz|null find($id, $lockMode = null, $lockVersion = null)
 * @method Quiz|null findOneBy(array $criteria, array $orderBy = null)
 * @method Quiz|null findOneByUuid(string $uuid)
 * @method Quiz[]    findAll()
 * @method Quiz[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuizRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Quiz::class);
    }

    /**
     * Or add an order ease this instead of taking the date that may change.
     *
     * @see QuestionRepository::findAllByDate
     */
    public function getQuestionsByDate(Quiz $quiz): array
    {
        return $this->createQueryBuilder('quiz')
            ->join('quiz.questions', 'questions')
            ->join('questions.question', 'question')
            ->andWhere('quiz.id = :id')
            ->setParameter('id', $quiz->getId())
            ->addOrderBy('question.createdAt', 'ASC')
            ->getQuery()
            ->execute();
    }
}
