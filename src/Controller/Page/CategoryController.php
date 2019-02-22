<?php

namespace App\Controller\Page;


use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    /**
     * @Route("/{slug<[a-zA-Z0-9\-_\/]+>}", name="page_category")
     * @param $slug
     * @return Response
     */
    public function category($slug)
    {
        $category = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findOneBy(['slug' => $slug]);

        $subCategories = $category->getSubCategories();

        return $this->render('page/category.html.twig', [
            'category' => $category,
            'subCategory' => $subCategories
        ]);
    }
}