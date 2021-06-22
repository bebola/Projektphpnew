<?php

namespace App\Controller;

use App\Form\UserType;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    private UserService $userService;

    /**
     * PhotosController constructor.
     *
     * @param \App\Service\UserService $userService User service
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
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
     *     "/admin/user/edit",
     *     methods={"GET", "PUT"},
     *     name="User_edit",
     * )
     */
    public function edit(Request $request): Response
    {
        $User = $this->getUser();

        $form = $this->createForm(UserType::class, $User, ['method' => 'PUT']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newPlainPassword = $form->get('newPassword')->getData();
            $this->userService->save($User, $newPlainPassword);

            $this->addFlash('success', 'message_updated_successfully');

            return $this->redirectToRoute('User_edit');
        }

        return $this->render(
            'User/edit.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }
}