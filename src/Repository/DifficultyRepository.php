<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Difficulty;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Difficulty|null find($id, $lockMode = null, $lockVersion = null)
 * @method Difficulty|null findOneBy(array $criteria, array $orderBy = null)
 * @method Difficulty[]    findAll()
 * @method Difficulty[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DifficultyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Difficulty::class);
    }
}
