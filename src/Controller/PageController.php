<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
{

    /**
     * @Route("/", name="page_home")
     */
    public function home()
    {
        return $this->render('page/home.html.twig');
    }

    /**
     * @param CategoryRepository $repository
     * @return Response
     */
    public function nav(CategoryRepository $repository)
    {
        $categories = $repository->findAll();

        return $this->render('components/_navbar.html.twig', [
            'categories' => $categories
        ]);
    }

}
