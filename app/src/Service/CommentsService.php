<?php
/**
 * CommentsService
 */
namespace App\Service;

use App\Entity\Comments;
use App\Repository\CommentsRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * Class CommentsService
 */
class CommentsService
{
    const PAGINATOR_ITEMS_PER_PAGE = 10;

    /** @var \App\Repository\CommentsRepository */
    private CommentsRepository $commentsRepository;

    /** @var \Knp\Component\Pager\PaginatorInterface */
    private PaginatorInterface $paginator;

    /**
     * CommentsService constructor.
     * @param CommentsRepository $commentsRepository
     * @param PaginatorInterface $paginator
     */
    public function __construct(CommentsRepository $commentsRepository, PaginatorInterface $paginator)
    {
        $this->commentsRepository = $commentsRepository;
        $this->paginator = $paginator;
    }

    /**
     * @param int $page
     *
     * @return \Knp\Component\Pager\Pagination\PaginationInterface
     */
    public function createPaginatedList(int $page): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->commentsRepository->queryAll(),
            $page,
            self::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * @param \App\Entity\Comments $comment
     */
    public function save(Comments $comment)
    {
        $this->commentsRepository->save($comment);
    }

    /**
     * @param \App\Entity\Comments $comment
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(Comments $comment)
    {
        $this->commentsRepository->delete($comment);
    }
}
