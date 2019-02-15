<?php

namespace App\Controller;


use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
     * @Route("/subcategory", name="page_subcategory")
    */
    public function subCategory()
    {
        return $this->render('page/sub_category.html.twig');
    }
    
    /**
     * @Route("/category")
     */
    public function category()
    {
        return $this->render('page/category.html.twig');
    }

    // @Route("/{categorie<[a-zA-Z0-9\-_\/]+>}/{subCategorie<[a-zA-Z0-9\-_\/]+>}/{slug<[a-zA-Z0-9\-_\/]+>}-{id<\d+>}", name="page_product")
    /**
     * @Route("/produit")
     */
    public function product(ProductRepository $repository)
    {
        //$product = $repository->find($id);

        return $this->render('page/product.html.twig');
    }
}