<?php

namespace App\Repository;

use App\Entity\Quiz;
use App\Entity\QuizQuestion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method QuizQuestion|null find($id, $lockMode = null, $lockVersion = null)
 * @method QuizQuestion|null findOneBy(array $criteria, array $orderBy = null)
 * @method QuizQuestion[]    findAll()
 * @method QuizQuestion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuizQuestionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, QuizQuestion::class);
    }

    public function getQuestionsByRank(Quiz $quiz): array
    {
        return $this->createQueryBuilder('quiz_question')
            ->join('quiz_question.quiz', 'quiz')
            ->join('quiz_question.question', 'question')
            ->andWhere('quiz_question.quiz = :id')
            ->setParameter('id', $quiz->getId())
            ->addOrderBy('quiz_question.rank', 'ASC')
            ->getQuery()
            ->execute();
    }
}
