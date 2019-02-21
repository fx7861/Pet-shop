<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use App\Entity\SubCategory;
use App\Entity\Category;
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
     * @Route("/{category<[a-zA-Z0-9\-_\/]+>}/{subCategory<[a-zA-Z0-9\-_\/]+>}/{slug<[a-zA-Z0-9\-_\/]+>}-{id<\d+>}",
     *     name="page_product")
     * @param ProductRepository $repository
     * @param $id
     * @return Response
     */
    public function product(ProductRepository $repository, $id)
    {
        $product = $repository->find($id);

        return $this->render('page/product.html.twig', [
            'product' => $product
        ]);
    }

    /**
     * @Route("/{category<[a-zA-Z0-9\-_\/]+>}/{slug<[a-zA-Z0-9\-_\/]+>}", name="page_subcategory")
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

    public function navbar(CategoryRepository $repository)
    {
        $categories = $repository->findAll();

        return $this->render('components/_navbar.html.twig', [
            'categories' => $categories
        ]);
    }

}
