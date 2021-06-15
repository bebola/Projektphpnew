<?php
/**
 * Categories controller.
 */

namespace App\Controller;

use App\Entity\Categories;
use App\Repository\CategoriesRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


/**
 * Class CategoriesController.
 *
 * @Route ("/Categories")
 */
class CategoriesController extends AbstractController
{
    private CategoriesRepository $CategoriesRepository;

    private PaginatorInterface $paginator;

    /**
     * CategoriesController constructor.
     *
     * @param \App\Repository\CategoriesRepository    $CategoriesRepository  ...
     * @param \Knp\Component\Pager\PaginatorInterface   $paginator   ...
     */

    public function __construct(CategoriesRepository $CategoriesRepository, PaginatorInterface $paginator)
    {
        $this->CategoriesRepository = $CategoriesRepository;
        $this->paginator = $paginator;
    }

    /**
     * ....
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route(
     *     "/",
     *     methods={"GET"},
     *     name="Categories_index",
     *
     * )
     */

    public function index(Request $request): Response
    {
        $pagination = $this->paginator->paginate(
            $this->CategoriesRepository->queryAll(),
            $request->query->getInt('page', 1),
            CategoriesRepository::PAGINATOR_ITEMS_PER_PAGE
        );

        return $this->render(
            'Categories/index.html.twig',
            ['pagination' => $pagination]
        );
    }

    /**
     * @param \App\Entity\Categories $Categories
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route(
     *     "/{id}",
     *     methods={"GET"},
     *     name="Categories_show",
     *     requirements={"id": "[1-9]\d*"},
     *
     * )
     */

    public function show(Categories $Categories): Response
    {
        return $this->render(
            'Categories/show.html.twig',
            ['Categories' => $Categories]
        );
    }

}