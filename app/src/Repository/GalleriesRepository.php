<?php

namespace App\Repository;

    use App\Entity\Galleries;
    use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
    use Doctrine\ORM\QueryBuilder;
    use Doctrine\Persistence\ManagerRegistry;

    /**
     * @method Galleries|null find($id, $lockMode = null, $lockVersion = null)
     * @method Galleries|null findOneBy(array $criteria, array $orderBy = null)
     * @method Galleries[]    findAll()
     * @method Galleries[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
     */
    class GalleriesRepository extends ServiceEntityRepository
    {
        /**
         * Items per page.
         *
         * Use constants to define configuration options that rarely change instead
         * of specifying them in app/config/config.yml.
         * See https://symfony.com/doc/current/best_practices.html#configuration
         *
         * @constant int
         */
        const PAGINATOR_ITEMS_PER_PAGE = 3;

        public function __construct(ManagerRegistry $registry)
        {
            parent::__construct($registry, Galleries::class);
        }
    /**
    * Save record.
    *
    * @param Galleries $Galleries Galleries entity
    *
    * @throws \Doctrine\ORM\ORMException
    * @throws \Doctrine\ORM\OptimisticLockException
    */

        public function save(Galleries $Galleries): void
        {
                $this->_em->persist($Galleries);
                $this->_em->flush();
        }
        /**
         * Delete record.
         *
         * @param Galleries $Galleries Galleries entity
         *
         * @throws \Doctrine\ORM\ORMException
         * @throws \Doctrine\ORM\OptimisticLockException
         */
        public function delete(Galleries $Galleries): void
        {
            $this->_em->remove($Galleries);
            $this->_em->flush();
        }


        public function queryAll(): QueryBuilder
        {
            return $this->getOrCreateQueryBuilder()
                ->orderBy('Galleries.updatedAt', 'DESC');
        }

        /**
         * @param int $id
         * @return Galleries|null
         * @throws \Doctrine\ORM\NonUniqueResultException
         */
        public function getOneWithPhotos(int $id): ?Galleries
        {
            $qb = $this->createQueryBuilder('Galleries')
                ->select('Galleries', 'Photos')
                ->join('Galleries.Photos', 'Photos')
                ->where('Galleries.id = :id')
                ->setParameter('id', $id)
            ;

            return $qb->getQuery()->getOneOrNullResult();
        }

        private function getOrCreateQueryBuilder(QueryBuilder $queryBuilder = null): QueryBuilder
        {
            return $queryBuilder ?? $this->createQueryBuilder( 'Galleries');
        }









        // /**
        //  * @return Galleries[] Returns an array of Galleries objects
        //  */
        /*
        public function findByExampleField($value)
        {
            return $this->createQueryBuilder('c')
                ->andWhere('c.exampleField = :val')
                ->setParameter('val', $value)
                ->orderBy('c.id', 'ASC')
                ->setMaxResults(10)
                ->getQuery()
                ->getResult()
            ;
        }
        */

        /*
        public function findOneBySomeField($value): ?Galleries
        {
            return $this->createQueryBuilder('c')
                ->andWhere('c.exampleField = :val')
                ->setParameter('val', $value)
                ->getQuery()
                ->getOneOrNullResult()
            ;
        }
        */
}
