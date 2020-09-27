<?php

namespace App\Repository;

use App\Entity\BoardGame;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BoardGame|null find($id, $lockMode = null, $lockVersion = null)
 * @method BoardGame|null findOneBy(array $criteria, array $orderBy = null)
 * @method BoardGame[]    findAll()
 * @method BoardGame[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BoardGameRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BoardGame::class);
    }

    /**
     * @return int|mixed|string
     */
    public function getAllSortByName()
    {
        return $this->createQueryBuilder('b')
            ->orderBy('b.title', 'ASC')
            ->orderBy('b.name', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
