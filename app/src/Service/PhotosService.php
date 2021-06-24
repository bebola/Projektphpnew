<?php
/*
 This work, including the code samples, is licensed under a Creative Commons BY-SA 3.0 license.
 */
namespace App\Service;

use App\Entity\Photos;
use App\Repository\PhotosRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class PhotosService.
 */
class PhotosService
{
    const PAGINATOR_ITEMS_PER_PAGE = 10;

    /** @var \App\Repository\PhotosRepository */
    private PhotosRepository $photosRepository;

    /** @var \Knp\Component\Pager\PaginatorInterface */
    private PaginatorInterface $paginator;

    /** @var \App\Service\FileUploader */
    private FileUploader $fileUploader;

    /**
     * PhotosController constructor.
     *
     * @param \App\Repository\PhotosRepository        $photosRepository Photos repository
     * @param \Knp\Component\Pager\PaginatorInterface $paginator        paginator interface
     * @param \App\Service\FileUploader               $fileUploader
     */
    public function __construct(PhotosRepository $photosRepository, PaginatorInterface $paginator, FileUploader $fileUploader)
    {
        $this->photosRepository = $photosRepository;
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
            $this->photosRepository->queryAll(),
            $page,
            self::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * @param int $id id
     *
     * @return Photos|null
     */
    public function getOne(int $id)
    {
        return $this->photosRepository->findOneById($id);
    }

    /**
     * @param int $id
     *
     * @return Photos|null
     *
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getOneWithComments(int $id)
    {
        return $this->photosRepository->getOneWithComments($id);
    }

    /**
     * @param Photos       $photos
     *
     * @param UploadedFile $file
     */
    public function save(Photos $photos, UploadedFile $file = null)
    {
        if ($file) {
            $filename = $this->fileUploader->upload($file);
            $photos->setFilename($filename);
        }

        $photos->setUpdatedAt(new \DateTime());
        $this->photosRepository->save($photos);
    }

    /**
     * @param Photos $photos
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(Photos $photos)
    {
        $this->photosRepository->delete($photos);
    }
}
