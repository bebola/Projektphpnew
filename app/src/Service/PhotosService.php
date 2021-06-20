<?php

namespace App\Service;

use App\Entity\Photos;
use App\Repository\PhotosRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class PhotosService
{
    const PAGINATOR_ITEMS_PER_PAGE = 10;

    /** @var \App\Repository\PhotosRepository */
    private PhotosRepository $PhotosRepository;

    /** @var \Knp\Component\Pager\PaginatorInterface */
    private PaginatorInterface $paginator;

    /** @var \App\Service\FileUploader */
    private FileUploader $fileUploader;

    /**
     * PhotosController constructor.
     *
     * @param \App\Repository\PhotosRepository $PhotosRepository Photos repository
     * @param \Knp\Component\Pager\PaginatorInterface   $paginator paginator interface
     * @param \App\Service\FileUploader $fileUploader
     */
    public function __construct(PhotosRepository $PhotosRepository, PaginatorInterface $paginator, FileUploader $fileUploader)
    {
        $this->PhotosRepository = $PhotosRepository;
        $this->paginator = $paginator;
        $this->fileUploader = $fileUploader;
    }

    /**
     * @param int $page
     *
     * @return \Knp\Component\Pager\Pagination\PaginationInterface
     */
    public function createPaginatedList(int $page): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->PhotosRepository->queryAll(),
            $page,
            self::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * @param int $id
     * @return Photos|null
     */
    public function getOne(int $id)
    {
        return $this->PhotosRepository->findOneById($id);
    }

    /**
     * @param Photos $Photos
     */
    public function save(Photos $Photos, UploadedFile $file = null)
    {
        if($file) {
            $filename = $this->fileUploader->upload($file);
            $Photos->setFilename($filename);
        }

        $Photos->setUpdatedAt(new \DateTime());
        $this->PhotosRepository->save($Photos);
    }

    /**
     * @param Photos $photos
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(Photos $Photos)
    {
        $this->PhotosRepository->delete($Photos);
    }
}