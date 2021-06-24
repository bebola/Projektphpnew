<?php
/**
 * Comments controller.
 */

namespace App\Controller;

use App\Entity\Comments;
use App\Form\CommentsType;
use App\Service\CommentsService;
use App\Service\PhotosService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CommentsController.
 *
 * @Route("/Comments")
 */
class CommentsController extends AbstractController
{
    /**
     * @var CommentsService
     */
    private CommentsService $commentsService;

    /**
     * @var PhotosService
     */
    private PhotosService $photosService;

    /**
     * CommentsController constructor.
     * @param CommentsService $commentsService Comments Service
     * @param PhotosService   $photosService   Photos Service
     */
    public function __construct(CommentsService $commentsService, PhotosService $photosService)
    {
        $this->commentsService = $commentsService;
        $this->photosService = $photosService;
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
     *     name="Comments_index",
     * )
     */
    public function index(Request $request): Response
    {
        $pagination = $this->commentsService->createPaginatedList($request->query->getInt('page', 1));

        return $this->render(
            'Comments/index.html.twig',
            ['pagination' => $pagination]
        );
    }

    /**
     * Show action.
     *
     * @param \App\Entity\Comments $comments Comments entity
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @Route(
     *     "/{id}",
     *     methods={"GET"},
     *     name="Comments_show",
     *     requirements={"id": "[1-9]\d*"},
     * )
     */
    public function show(Comments $comments): Response
    {
        return $this->render(
            'Comments/show.html.twig',
            ['Comments' => $comments]
        );
    }
    /**
     * Create action.
     * @param \Symfony\Component\HttpFoundation\Request $request HTTP request
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/create/{photoId}/photo",
     *     methods={"GET", "POST"},
     *     name="Comments_create",
     * )
     *
     * @param int                                       $photoId PhotoId
     *
     */
    public function create(Request $request, int $photoId): Response
    {
        $photos = $this->photosService->getOne($photoId);
        if (null === $photos) {
            return $this->redirectToRoute('Comments_index');
        }

        $comments = new Comments();
        $form = $this->createForm(CommentsType::class, $comments, [
            'action' => $this->generateUrl('Comments_create', ['photoId' => $photos->getId()]),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comments->setPhotos($photos);
            $this->commentsService->save($comments);

            $this->addFlash('success', 'message_created_successfully');

            return $this->redirectToRoute('Comments_index');
        }

        return $this->render(
            'Comments/create.html.twig',
            ['form' => $form->createView()]
        );
    }
    /**
     * Delete action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request  HTTP request
     * @param \App\Entity\Comments                      $comments Comments entity
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
     *     name="Comments_delete",
     * )
     */
    public function delete(Request $request, Comments $comments): Response
    {
        $form = $this->createForm(FormType::class, $comments, ['method' => 'DELETE']);
        $form->handleRequest($request);

        if ($request->isMethod('DELETE') && !$form->isSubmitted()) {
            $form->submit($request->request->get($form->getName()));
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $this->commentsService->delete($comments);

            $this->addFlash('success', 'message.deleted_successfully');

            return $this->redirectToRoute('Comments_index');
        }

        return $this->render(
            'Comments/delete.html.twig',
            [
                'form' => $form->createView(),
                'Comments' => $comments,
            ]
        );
    }
}
