<?php
/**
 * Photos controller.
 */

namespace App\Controller;

use App\Entity\Photos;
use App\Form\PhotosType;
use App\Repository\PhotosRepository;
use App\Service\PhotosService;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class PhotosController.
 *
 * @Route("/Photos")
 *
 */
class PhotosController extends AbstractController
{
    private PhotosService $photosService;

    /**
     * PhotosController constructor.
     *
     * @param \App\Service\PhotosService $photosService Photos service
     */
    public function __construct(PhotosService $photosService)
    {
        $this->photosService = $photosService;
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
        $pagination = $this->photosService->createPaginatedList($request->query->getInt('page', 1));

        return $this->render(
          'Photos\index.html.twig',
        ['pagination' => $pagination]
      );
    }

    /**
     * Show action.
     *
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\Response HTTP Response
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
        $Photos = $this->photosService->getOneWithComments($id);

        return $this->render(
            'Photos/show.html.twig',
            ['Photos' => $Photos]
        );
    }
    /**
     * Create action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request            HTTP request
     * @param \App\Repository\PhotosRepository        $PhotosRepository Photos repository
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/create",
     *     methods={"GET", "POST"},
     *     name="photos_create",
     * )
     * @IsGranted("ROLE_ADMIN")
     */
    public function create(Request $request): Response
    {
        $Photos = new Photos();
        $form = $this->createForm(PhotosType::class, $Photos);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->photosService->save($Photos, $form->get('file')->getData());

            $this->addFlash('success', 'message_created_successfully');

            return $this->redirectToRoute('Photos_index');
        }

        return $this->render(
            'Photos/create.html.twig',
            ['form' => $form->createView()]
        );
    }
    /**
     * Edit action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request            HTTP request
     * @param \App\Entity\Photos                      $Photos           Photos entity
     * @param \App\Repository\PhotosRepository        $PhotosRepository Photos repository
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/{id}/edit",
     *     methods={"GET", "PUT"},
     *     requirements={"id": "[1-9]\d*"},
     *     name="Photos_edit",
     * )
     */
    public function edit(Request $request, Photos $Photos): Response
    {
        $form = $this->createForm(PhotosType::class, $Photos, ['method' => 'PUT']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->photosService->save($Photos, $form->get('file')->getData());

            $this->addFlash('success', 'message_updated_successfully');

            return $this->redirectToRoute('Photos_index');
        }

        return $this->render(
            'Photos/edit.html.twig',
            [
                'form' => $form->createView(),
                'Photos' => $Photos,
            ]
        );
    }
    /**
     * Delete action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request            HTTP request
     * @param \App\Entity\Photos                     $Photos           Photos entity
     * @param \App\Repository\PhotosRepository        $PhotosRepository Photos repository
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
     *     name="Photos_delete",
     * )
     */
    public function delete(Request $request, Photos $Photos): Response
    {
        $form = $this->createForm(FormType::class, $Photos, ['method' => 'DELETE']);
        $form->handleRequest($request);

        if ($request->isMethod('DELETE') && !$form->isSubmitted()) {
            $form->submit($request->request->get($form->getName()));
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $this->photosService->delete($Photos);

            $this->addFlash('success', 'message.deleted_successfully');

            return $this->redirectToRoute('Photos_index');
        }

        return $this->render(
            'Photos/delete.html.twig',
            [
                'form' => $form->createView(),
                'Photos' => $Photos,
            ]
        );
    }
}
