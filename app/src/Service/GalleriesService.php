<?php
/**
 * Galleries service.
 */

namespace App\Service;

use App\Entity\Galleries;
use App\Repository\GalleriesRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * Class GalleriesService.
 */
class GalleriesService
{
    const PAGINATOR_ITEMS_PER_PAGE = 10;
    /**
     * Galleries repository.
     *
     * @var \App\Repository\GalleriesRepository
     */
    private $galleriesRepository;

    /**
     * Paginator.
     *
     * @var \Knp\Component\Pager\PaginatorInterface
     */
    private $paginator;
    /**
     * GalleriesService constructor.
     *
     * @param \App\Repository\GalleriesRepository     $galleriesRepository Galleries repository
     * @param \Knp\Component\Pager\PaginatorInterface $paginator           Paginator
     *
     */
    public function __construct(GalleriesRepository $galleriesRepository, PaginatorInterface $paginator)
    {
        $this->galleriesRepository = $galleriesRepository;
        $this->paginator = $paginator;
    }
    /**
     * Create paginated list.
     *
     * @param int $page Page number
     *
     * @return \Knp\Component\Pager\Pagination\PaginationInterface Paginated list
     *
     */
    public function createPaginatedList(int $page): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->galleriesRepository->queryAll(),
            $page,
            GalleriesRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }
    /**
     * Save Galleries.
     *
     * @param \App\Entity\Galleries $galleries Galleries entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Galleries $galleries): void
    {
        $this->galleriesRepository->save($galleries);
    }

    /**
     * Delete Galleries.
     *
     * @param \App\Entity\Galleries $galleries Galleries entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(Galleries $galleries): void
    {
        $this->galleriesRepository->delete($galleries);
    }

    /**
     * @param int $id
     *
     * @return Galleries|null
     *
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getOneWithPhotos(int $id)
    {
        return $this->galleriesRepository->getOneWithPhotos($id);
    }
}
