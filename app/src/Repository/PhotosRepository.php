<?php
/**
 * Photos repository.
 */

namespace App\Repository;

use App\Entity\Photos;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class PhotosRepository.
 *
 * @method Photos|null find($id, $lockMode = null, $lockVersion = null)
 * @method Photos|null findOneBy(array $criteria, array $orderBy = null)
 * @method Photos[]    findAll()
 * @method Photos[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PhotosRepository extends ServiceEntityRepository
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
     * PhotosRepository constructor.
     *
     * @param \Doctrine\Common\Persistence\ManagerRegistry $registry Manager registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Photos::class);
    }
    /**
     * Query all records.
     *
     * @return \Doctrine\ORM\QueryBuilder Query builder
     */
    public function queryAll(): QueryBuilder
    {
        return $this->getOrCreateQueryBuilder()
            ->orderBy('Photos.updatedAt', 'DESC');
    }

    /**
     * @param int $id
     * @return \App\Entity\Photos|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getOneWithComments(int $id)
    {
        $qb = $this->createQueryBuilder('Photos')
            ->select('Photos', 'Comments')
            ->join('Photos.Comments', 'Comments')
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
        return $queryBuilder ?? $this->createQueryBuilder('Photos');
    }
    /**
     * Save record.
     *
     * @param \App\Entity\Photos $Photos Photos entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Photos $Photos): void
    {
        $this->_em->persist($Photos);
        $this->_em->flush();
    }
    /**
    * Delete record.
    *
    * @param \App\Entity\Photos $Photos Photos entity
    *
    * @throws \Doctrine\ORM\ORMException
    * @throws \Doctrine\ORM\OptimisticLockException
    */
    public function delete(Photos $Photos): void
    {
        $this->_em->remove($Photos);
        $this->_em->flush();
    }
}
