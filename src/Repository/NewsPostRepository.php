<?php

namespace App\Repository;

use App\Entity\NewsPost;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method NewsPost|null find($id, $lockMode = null, $lockVersion = null)
 * @method NewsPost|null findOneBy(array $criteria, array $orderBy = null)
 * @method NewsPost[]    findAll()
 * @method NewsPost[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NewsPostRepository extends AbstractRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NewsPost::class);
    }
}
