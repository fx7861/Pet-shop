<?php

namespace App\Controller;

use App\Entity\Product;
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
        $repository = $this->getDoctrine()->getRepository(Product::class);

        $products = $repository->findLastArticle();

        return $this->render('page/home.html.twig', [
            'products' => $products
        ]);
    }

    /**
     * @param CategoryRepository $repository
     * @return Response
     */
    public function nav(CategoryRepository $repository)
    {
        $categories = $repository->findAll();

        return $this->render('components/_nav.html.twig', [
            'categories' => $categories
        ]);
    }

}
