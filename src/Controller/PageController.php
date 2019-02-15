<?php

namespace App\Controller;


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

}