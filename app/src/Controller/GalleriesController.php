<?php
/**
 * Galleries controller.
 */

namespace App\Controller;

use App\Entity\Galleries;
use App\Form\GalleriesType;
use App\Service\GalleriesService;
use Doctrine\ORM\OptimisticLockException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class GalleriesController.
 *
 * @Route ("/Galleries")
 *
 */
class GalleriesController extends AbstractController
{
    private GalleriesService $galleriesService;

    /**
     * GalleriesController constructor.
     *
     * @param \App\Service\GalleriesService $galleriesService Galleries service
     */
    public function __construct(GalleriesService $galleriesService)
    {
        $this->galleriesService = $galleriesService;
    }

    /**
     * Index action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request HTTP request
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @Route(
     *     "/",
     *     methods={"GET"},
     *     name="Galleries_index",
     * )
     */
    public function index(Request $request): Response
    {
        $pagination = $this->galleriesService->createPaginatedList($request->query->getInt('page', 1));

        return $this->render(
            'Galleries\index.html.twig',
            ['pagination' => $pagination]
        );
    }

    /**
     * Show action.
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @Route(
     *     "/{id}",
     *     methods={"GET"},
     *     name="Galleries_show",
     *     requirements={"id": "[1-9]\d*"},
     * )
     *
     * @param Request $request request
     * @param int     $id      id
     *
     *
     * @throws \Doctrine\ORM\NonUniqueResultException
     *
     */
    public function show(Request $request, int $id): Response
    {
        $galleries = $this->galleriesService->getOneWithPhotos($id);

        return $this->render(
            'Galleries/show.html.twig',
            ['Galleries' => $galleries]
        );
    }
    /**
     * Create action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request HTTP request
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
    public function create(Request $request): Response
    {
        $galleries = new Galleries();
        $form = $this->createForm(GalleriesType::class, $galleries);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->galleriesService->save($galleries);

            $this->addFlash('success', 'message_created_successfully');

            return $this->redirectToRoute('Galleries_index');
        }

        return $this->render(
            'Galleries/create.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * Edit action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request   HTTP request
     * @param \App\Entity\Galleries                     $galleries Galleries entity
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws OptimisticLockException
     *
     * @Route(
     *     "/{id}/edit",
     *     methods={"GET", "PUT"},
     *     requirements={"id": "[1-9]\d*"},
     *     name="galleries_edit",
     * )
     */
    public function edit(Request $request, Galleries $galleries): Response
    {
        $form = $this->createForm(GalleriesType::class, $galleries, ['method' => 'PUT']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->galleriesService->save($galleries);

            $this->addFlash('success', 'message_updated_successfully');

            return $this->redirectToRoute('Galleries_index');
        }

        return $this->render(
            'Galleries/edit.html.twig',
            [
                'form' => $form->createView(),
                'Galleries' => $galleries,
            ]
        );
    }
    /**
     * Delete action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request   HTTP request
     * @param \App\Entity\Galleries                     $galleries Galleries entity
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
    public function delete(Request $request, Galleries $galleries): Response
    {
        $form = $this->createForm(FormType::class, $galleries, ['method' => 'DELETE']);
        $form->handleRequest($request);

        if ($request->isMethod('DELETE') && !$form->isSubmitted()) {
            $form->submit($request->request->get($form->getName()));
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $this->galleriesService->delete($galleries);

            $this->addFlash('success', 'message.deleted_successfully');

            return $this->redirectToRoute('Galleries_index');
        }

        return $this->render(
            'Galleries/delete.html.twig',
            [
                'form' => $form->createView(),
                'Galleries' => $galleries,
            ]
        );
    }
}
