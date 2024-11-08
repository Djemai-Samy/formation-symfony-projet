<?php

namespace App\Repository;

use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Post>
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    public function sauvegarder(Post $post): void
    {
        $this->getEntityManager()->persist($post);
        $this->getEntityManager()->flush();
    }

    public function supprimer(Post $post): void
    {
        $this->getEntityManager()->remove($post);
        $this->getEntityManager()->flush();
    }
}