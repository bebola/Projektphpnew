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
    private $GalleriesRepository;

    /**
     * Paginator.
     *
     * @var \Knp\Component\Pager\PaginatorInterface
     */
    private $paginator;
    /**
     * GalleriesService constructor.
     *
     * @param \App\Repository\GalleriesRepository      $GalleriesRepository Galleries repository
     * @param \Knp\Component\Pager\PaginatorInterface $paginator          Paginator
     * @param \App\Service\FileUploader $fileUploader
     */
    public function __construct(GalleriesRepository $GalleriesRepository, PaginatorInterface $paginator)
    {
        $this->GalleriesRepository = $GalleriesRepository;
        $this->paginator = $paginator;
    }
    /**
     * Create paginated list.
     *
     * @param int $page Page number
     *
     * @return \Knp\Component\Pager\Pagination\PaginationInterface Paginated list
     */
    public function createPaginatedList(int $page): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->GalleriesRepository->queryAll(),
            $page,
            GalleriesRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }
    /**
     * Save Galleries.
     *
     * @param \App\Entity\Galleries $category Galleries entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Galleries $Galleries): void
    {
        $this->GalleriesRepository->save($Galleries);
    }

    /**
     * Delete Galleries.
     *
     * @param \App\Entity\Galleries $Galleries Galleries entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(Galleries $Galleries): void
    {
        $this->GalleriesRepository->delete($Galleries);
    }
}