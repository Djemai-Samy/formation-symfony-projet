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

    function search($page, $onlyPublic = false, $query = "", $userID = "", $limit = 10)
    {
        $qb = $this->createQueryBuilder("c")
            ->orWhere("c.titre LIKE :query ")
            ->orWhere("c.description LIKE :query ")
            ->orWhere("c.categorie LIKE :query ")
            ->setParameter("query", "%" . $query . "%")
            ->setMaxResults($limit)
            ->setFirstResult($page * $limit);

        if ($onlyPublic) {
            $qb->andWhere("c.isPublic = :isPublic")->setParameter("isPublic", $onlyPublic);
        }

        if ($userID != "") {
            $qb->andWhere("c.utilisateur = :utilisateur")->setParameter("utilisateur", $userID);
        }
        return $qb->getQuery()->getResult();
    }
}
