<?php
/**
 *
 */

namespace App\Controller;

use App\Repository\PhotosRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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

    /**
     * PhotosController constructor.
     * @param \App\Repository\PhotosRepository $PhotosRepository
     */

    public function __construct(PhotosRepository $PhotosRepository)
    {
        $this->PhotosRepository = $PhotosRepository;
    }


    /**
     * Index_action.
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
    public function index(): Response
    {
        $Photos =$this->PhotosRepository->findAll();

      return $this->render(

          'Photos\index.html.twig',
        ['Photos' => $Photos]
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
        return new Response('PhotosController@show');
    }
}
