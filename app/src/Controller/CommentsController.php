<?php
/**
 * Comments controller.
 */

namespace App\Controller;

use App\Entity\Comments;
use App\Form\CommentsType;
use App\Repository\CommentsRepository;
use Knp\Component\Pager\PaginatorInterface;
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
     * Index action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request            HTTP request
     * @param \App\Repository\CommentsRepository        $CommentsRepository Comments repository
     * @param \Knp\Component\Pager\PaginatorInterface   $paginator          Paginator
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @Route(
     *     "/",
     *     methods={"GET"},
     *     name="Comments_index",
     * )
     */
    public function index(Request $request, CommentsRepository $CommentsRepository, PaginatorInterface $paginator): Response
    {
        $pagination = $paginator->paginate(
            $CommentsRepository->queryAll(),
            $request->query->getInt('page', 1),
            CommentsRepository::PAGINATOR_ITEMS_PER_PAGE
        );

        return $this->render(
            'Comments/index.html.twig',
            ['pagination' => $pagination]
        );
    }

    /**
     * Show action.
     *
     * @param \App\Entity\Comments $Comments Comments entity
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
    public function show(Comments $Comments): Response
    {
        return $this->render(
            'Comments/show.html.twig',
            ['Comments' => $Comments]
        );
    }
    /**
     * Create action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request            HTTP request
     * @param \App\Repository\CommentsRepository        $CommentsRepository Comments repository
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/create",
     *     methods={"GET", "POST"},
     *     name="Comments_create",
     * )
     */
    public function create(Request $request, CommentsRepository $CommentsRepository): Response
    {
        $Comments = new Comments();
        $form = $this->createForm(CommentsType::class, $Comments);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $Comments->setCreatedAt(new \DateTime());
            $Comments->setUpdatedAt(new \DateTime());
            $CommentsRepository->save($Comments);

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
     * @param \Symfony\Component\HttpFoundation\Request $request            HTTP request
     * @param \App\Entity\Comments                    $Comments           Comments entity
     * @param \App\Repository\CommentsRepository        $CommentsRepository Comments repository
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
    public function delete(Request $request, Comments $Comments, CommentsRepository $CommentsRepository): Response
    {
        $form = $this->createForm(FormType::class, $Comments, ['method' => 'DELETE']);
        $form->handleRequest($request);

        if ($request->isMethod('DELETE') && !$form->isSubmitted()) {
            $form->submit($request->request->get($form->getName()));
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $CommentsRepository->delete($Comments);
            $this->addFlash('success', 'message.deleted_successfully');

            return $this->redirectToRoute('Comments_index');
        }

        return $this->render(
            'Comments/delete.html.twig',
            [
                'form' => $form->createView(),
                'Comments' => $Comments,
            ]
        );
    }
}