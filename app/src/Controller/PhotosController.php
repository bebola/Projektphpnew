<?php
/**
 * Photos controller.
 */

namespace App\Controller;

use App\Entity\Photos;
use App\Form\PhotosType;
use App\Repository\PhotosRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
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
     *
     * @param \App\Repository\PhotosRepository $PhotosRepository Photos repository
     * @param \Knp\Component\Pager\PaginatorInterface   $paginator paginator interface
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
        $Photos = $this->PhotosRepository->findOneById($id);
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
     */
    public function create(Request $request, PhotosRepository $PhotosRepository): Response
    {
        $Photos = new Photos();
        $form = $this->createForm(PhotosType::class, $Photos);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $Photos->setCreatedAt(new \DateTime());
            $Photos->setUpdatedAt(new \DateTime());
            $PhotosRepository->save($Photos);

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
    public function edit(Request $request, Photos $Photos, PhotosRepository $PhotosRepository): Response
    {
        $form = $this->createForm(PhotosType::class, $Photos, ['method' => 'PUT']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $Photos->setUpdatedAt(new \DateTime());
            $PhotosRepository->save($Photos);

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
    public function delete(Request $request, Photos $Photos, PhotosRepository $PhotosRepository): Response
    {
        $form = $this->createForm(FormType::class, $Photos, ['method' => 'DELETE']);
        $form->handleRequest($request);

        if ($request->isMethod('DELETE') && !$form->isSubmitted()) {
            $form->submit($request->request->get($form->getName()));
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $PhotosRepository->delete($Photos);
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
