<?php

namespace App\Repository;

use App\Entity\Collection;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class CollectionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Collection::class);
    }

    public function sauvegarder(Collection $collection): void
    {
        $this->getEntityManager()->persist($collection);
        $this->getEntityManager()->flush();
    }

    public function supprimer(Collection $collection): void
    {
        $this->getEntityManager()->remove($collection);
        $this->getEntityManager()->flush();
    }
}
