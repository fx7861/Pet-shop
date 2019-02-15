<?php

namespace App\Controller;


use App\Entity\Product;
use App\Entity\SubCategory;
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
     * @Route("/{category<[a-zA-Z0-9\-_\/]+>}/{slug<[a-zA-Z0-9\-_\/]+>}", name="page_subcategory")
     * @param $slug
     * @return Response
     */
    public function subCategory($slug)
    {

        $subCategory = $this->getDoctrine()
                        ->getRepository(SubCategory::class)
                        ->findOneBy(['slug' => $slug]);
        $products = $subCategory->getProducts();


        return $this->render('page/sub_category.html.twig', [
            'subCategory' => $subCategory,
            'products' => $products
        ]);
    }
    
    /**
     * @Route("/category")
     */
    public function category()
    {
        return $this->render('page/category.html.twig');
    }

}