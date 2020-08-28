<?php declare(strict_types=1);

namespace App\Repository;

use App\Entity\Question;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Question|null find(int $id, $lockMode = null, $lockVersion = null)
 * @method Question|null findOneBy(array $criteria, array $orderBy = null)
 * @method Question[]    findAll()
 * @method Question[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuestionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Question::class);
    }

    public function findOneWithNav(int $id): ?Question
    {
        try {
            return $this->createQueryBuilder('q')
                ->andWhere('q.id = :id')
                ->setParameter('id', $id)
                ->join('q.answers', 'answers')
                ->join('q.suggestedBy', 'suggestedBy')
                ->join('q.difficulty', 'difficulty')
                ->leftJoin('q.previousQuestion', 'previousQuestion')
                ->leftJoin('q.nextQuestion', 'nextQuestion')
                ->getQuery()->getSingleResult();
        } catch (NoResultException $exception) {
            return null;
        }
    }
}
