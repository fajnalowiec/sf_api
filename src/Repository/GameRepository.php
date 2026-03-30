<?php

namespace App\Repository;

use App\Entity\Game;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Game>
 */
class GameRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Game::class);
    }

    public function getMostLovedGames(int $limit = 10): array
    {
        return $this->createQueryBuilder('g')
            ->select('g, COUNT(lg.id) AS lovesCount')
            ->leftJoin('g.lovedGames', 'lg')
            ->groupBy('g.id')
            ->orderBy('lovesCount', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    public function getAll(int $offset = 0, int $limit = 10): array
    {
        return $this->createQueryBuilder('g')
            ->setMaxResults($limit)
            ->setFirstResult($offset)
            ->orderBy('g.id', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
