<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

abstract class AbstractRepository extends ServiceEntityRepository
{
    public const ORDER_DIRECTION_ASC = 'ASC';
    public const ORDER_DIRECTION_DESC = 'DESC';
}
