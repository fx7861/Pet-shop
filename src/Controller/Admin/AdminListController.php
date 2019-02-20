<?php

namespace App\Controller\Admin;


use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use App\Repository\SubCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminListController extends AbstractController
{
    /**
     * @Route("/admin/product/list", name="admin_list_product")
     * @param ProductRepository $repository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listProduct(ProductRepository $repository)
    {
        $products = $repository->findAll();

        return $this->render('admin/list/listProduct.html.twig', [
            'products' => $products
        ]);
    }

    /**
     * @Route("/admin/category/list", name="admin_list_category")
     * @param CategoryRepository $repository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listCategory(CategoryRepository $repository)
    {
        $categories = $repository->findAll();

        return $this->render('admin/list/listCategory.html.twig', [
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/admin/subcategory/list", name="admin_list_subcategory")
     */
    public function listSubCategory(SubCategoryRepository $repository)
    {
        $subCategories = $repository->findAll();

        return $this->render('admin/list/listSubCategory.html.twig', [
            'subCategories' => $subCategories
        ]);
    }
}