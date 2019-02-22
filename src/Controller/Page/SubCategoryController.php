<?php

namespace App\Controller\Page;


use App\Entity\Category;
use App\Entity\SubCategory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SubCategoryController extends AbstractController
{
    /**
     * @Route("/{category<[a-zA-Z0-9\-_\/]+>}/{slug<[a-zA-Z0-9\-_\/]+>}", name="page_subcategory")
     * @param $category
     * @param $slug
     * @return Response
     */
    public function subCategory($category, $slug)
    {
        $cat = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findOneBy(['slug' => $category ]);

        $subCategory = $this->getDoctrine()
            ->getRepository(SubCategory::class)
            ->findOneBy(['slug' => $slug, 'category' => $cat]);


        $products = $subCategory->getProducts();

        return $this->render('page/sub_category.html.twig', [
            'subCategory' => $subCategory,
            'products' => $products
        ]);
    }
}