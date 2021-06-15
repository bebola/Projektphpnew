<?php
/**
 * Photos controller.
 */

namespace App\Controller;

use App\Repository\PhotosRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class PhotosController.
 *
 * @Route("/Photos")
 */
class PhotosController extends AbstractController
{

    private PhotosRepository $PhotosRepository;

    private PaginatorInterface $paginator;

    /**
     * PhotosController constructor.
     * @param \App\Repository\PhotosRepository $PhotosRepository
     * @param \Knp\Component\Pager\PaginatorInterface   $paginator
     */

    public function __construct(PhotosRepository $PhotosRepository, PaginatorInterface $paginator)
    {
        $this->PhotosRepository = $PhotosRepository;
        $this->paginator = $paginator;
    }


    /**
     * Index_action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request        HTTP request
     * @param \App\Repository\PhotosRepository            $PhotosRepository Photos repository
     * @param \Knp\Component\Pager\PaginatorInterface   $paginator      Paginator
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP Response
     *
     * @Route(
     *     "/",
     *     methods={"GET"},
     *     name="Photos_index",
     *
     * )
     */
    public function index(Request $request): Response
    {
        $pagination = $this->paginator->paginate(
            $this->PhotosRepository->queryAll(),
            $request->query->getInt('page', 1),
            PhotosRepository::PAGINATOR_ITEMS_PER_PAGE
        );
        dump($pagination);

        return $this->render(

          'Photos\index.html.twig',
        ['pagination' => $pagination]
      );
    }

    /**
     * ...
     *
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\Response ...
     *
     * @Route(
     *     "/{id}",
     *     methods={"GET"},
     *     name="Photos_show",
     *     requirements={"id": "[1-9]\d*"},
     * )
     */

    public function show(int $id): Response
    {
        $Photos = $this->PhotosRepository->findOneById($id);

        return $this->render(
            'Photos/show.html.twig',
        ['Photos' => $Photos]
        );
    }
}
