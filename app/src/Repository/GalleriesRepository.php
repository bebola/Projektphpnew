<?php
/**
 * Galleries repository.
 */
namespace App\Repository;

    use App\Entity\Galleries;
    use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
    use Doctrine\ORM\QueryBuilder;
    use Doctrine\Persistence\ManagerRegistry;

    /**
     * Class GalleriesRepository
     *
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
        const PAGINATOR_ITEMS_PER_PAGE = 10;
        /**
         * GalleriesRepository constructor.
         *
         * @param \Doctrine\Common\Persistence\ManagerRegistry $registry Manager registry
         */

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
        /**
         * Query all records.
         *
         * @return \Doctrine\ORM\QueryBuilder Query builder
         */
        public function queryAll(): QueryBuilder
        {
            return $this->getOrCreateQueryBuilder()
                ->orderBy('Galleries.updatedAt', 'DESC');
        }
        /**
         * Get or create new query builder.
         *
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
        /**
         * Get or create new query builder.
         *
         * @param \Doctrine\ORM\QueryBuilder|null $queryBuilder Query builder
         *
         * @return \Doctrine\ORM\QueryBuilder Query builder
         */
        private function getOrCreateQueryBuilder(QueryBuilder $queryBuilder = null): QueryBuilder
        {
            return $queryBuilder ?? $this->createQueryBuilder( 'Galleries');
        }

}
