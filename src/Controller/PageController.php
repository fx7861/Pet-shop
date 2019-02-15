<?php

namespace App\Controller;


use App\Entity\Category;
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
     * @Route("/{slug<[a-zA-Z0-9\-_\/]+>}", name="page_category")
     */
    public function category($slug)
    {
        $category = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findOneBy(['slug' => $slug]);

        $subCategories = $category->getSubCategories();

        return $this->render('page/category.html.twig',[
                 'category' => $category,
                 'subCategory' => $subCategories
            ]);
    }
}

