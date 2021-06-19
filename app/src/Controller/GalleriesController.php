<?php
/**
 * Galleries controller.
 */

namespace App\Controller;

use App\Entity\Galleries;
use App\Form\GalleriesType;
use App\Repository\GalleriesRepository;
use Doctrine\ORM\OptimisticLockException;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


/**
 * Class GalleriesController.
 *
 * @Route ("/Galleries")
 */
class GalleriesController extends AbstractController
{
    private GalleriesRepository $GalleriesRepository;

    private PaginatorInterface $paginator;

    /**
     * GalleriesController constructor.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request            HTTP request
     * @param \App\Repository\GalleriesRepository    $GalleriesRepository  Galleries repository
     * @param \Knp\Component\Pager\PaginatorInterface   $paginator   paginator interface
     */

    public function __construct(GalleriesRepository $GalleriesRepository, PaginatorInterface $paginator)
    {
        $this->GalleriesRepository = $GalleriesRepository;
        $this->paginator = $paginator;
    }

    /**
     * Index action.
     *
     * @param Request                   $request                    HTTP request
     * @param GalleriesRepository     $GalleriesRepository       Galleries repository
     * @param PaginatorInterface        $paginator                  Paginator
     *
     * @return Response                                             HTTP response
     *

     * @Route(
     *     "/",
     *     methods={"GET"},
     *     name="Galleries_index",
     *
     * )
     */

    public function index(Request $request, GalleriesRepository $GalleriesRepository, PaginatorInterface $paginator): Response

    {
        $pagination = $paginator->paginate(
            $GalleriesRepository->queryAll(),
            $request->query->getInt('page', 1),
            GalleriesRepository::PAGINATOR_ITEMS_PER_PAGE
        );


        return $this->render(
            'Galleries/index.html.twig',
            ['pagination' => $pagination]
        );
    }

    /**
     * Show action.
     *
     * @param \App\Entity\Galleries $Galleries
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route(
     *     "/{id}",
     *     methods={"GET"},
     *     name="Galleries_show",
     *     requirements={"id": "[1-9]\d*"},
     *
     * )
     */

    public function show(Galleries $Galleries): Response
    {
        return $this->render(
            'Galleries/show.html.twig',
            ['Galleries' => $Galleries]
        );
    }
    /**
     * Create action.
     *
     * @param \Symfony\Component\HttpFoundation\Request     $request                HTTP request
     * @param \App\Repository\GalleriesRepository          $GalleriesRepository   Galleries Repository
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws OptimisticLockException
     *
     * @Route(
     *     "/create",
     *     methods={"GET", "POST"},
     *     name="galleries_create",
     * )
     */
    public function create(Request $request, GalleriesRepository $GalleriesRepository): Response
    {
        $Galleries = new Galleries();
        $form = $this->createForm(GalleriesType::class, $Galleries);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $GalleriesRepository->save($Galleries);

            $this->addFlash('success', 'message_created_successfully');

            return $this->redirectToRoute( 'Galleries_index');
        }
      return $this->render(
        'Galleries/create.html.twig',
          ['form' => $form->createView()]
      );
    }

    /**
     * Edit action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request HTTP request
     * @param \App\Entity\Galleries $Galleries Galleries entity
     * @param \App\Repository\GalleriesRepository $GalleriesRepository Galleries  repository
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws OptimisticLockException
     * @Route(
     *     "/{id}/edit",
     *     methods={"GET", "PUT"},
     *     requirements={"id": "[1-9]\d*"},
     *     name="galleries_edit",
     * )
     */
    public function edit(Request $request, Galleries $Galleries, GalleriesRepository $GalleriesRepository ): Response
    {
        $form = $this->createForm(GalleriesType::class, $Galleries, ['method' => 'PUT']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $GalleriesRepository->save($Galleries);

            $this->addFlash('success', 'message_updated_successfully');

            return $this->redirectToRoute('Galleries_index');
        }

        return $this->render(
            'Galleries/edit.html.twig',
            [
                'form' => $form->createView(),
                'Galleries' => $Galleries,
            ]
        );
    }
    /**
     * Delete action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request            HTTP request
     * @param \App\Entity\Galleries                     $Galleries         Galleries entity
     * @param \App\Repository\GalleriesRepository        $GalleriesRepository Galleries repository
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/{id}/delete",
     *     methods={"GET", "DELETE"},
     *     requirements={"id": "[1-9]\d*"},
     *     name="Galleries_delete",
     * )
     */
    public function delete(Request $request, Galleries $Galleries, GalleriesRepository $GalleriesRepository): Response
    {
        $form = $this->createForm(FormType::class, $Galleries, ['method' => 'DELETE']);
        $form->handleRequest($request);

        if ($request->isMethod('DELETE') && !$form->isSubmitted()) {
            $form->submit($request->request->get($form->getName()));
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $GalleriesRepository->delete($Galleries);
            $this->addFlash('success', 'message.deleted_successfully');

            return $this->redirectToRoute('Galleries_index');
        }

        return $this->render(
            'Galleries/delete.html.twig',
            [
                'form' => $form->createView(),
                'Galleries' => $Galleries,
            ]
        );
    }
}