<?php

namespace App\Controller\Admin;

use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use App\Repository\SubCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Routing\Annotation\Route;

class AdminDeleteController extends AbstractController
{

    /**
     * @Route("/admin/product/delete/{id<\d+>}", name="admin_delete_product")
     * @param ProductRepository $repository
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function addProduct(ProductRepository $repository, $id)
    {
        $product = $repository->find($id);

        $fileSystem = new Filesystem();
        $fileSystem->remove($this->getParameter('products_assets_dir') . '/' . $product->getPhoto());

        $em = $this->getDoctrine()->getManager();
        $em->remove($product);
        $em->flush();

        $this->addFlash('add', 'Produit supprimé avec succès');

        return $this->redirectToRoute('admin_list_product');
    }

    /**
     * @Route("/admin/category/delete/{id<\d+>}", name="admin_delete_category")
     * @param CategoryRepository $repository
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function addCategory(CategoryRepository $repository, $id)
    {
        $category = $repository->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($category);
        $em->flush();

        $this->addFlash('add', 'Catégorie supprimé avec succès');

        return $this->redirectToRoute('admin_list_category');
    }

    /**
     * @Route("/admin/subcategory/delete/{id<\d+>}", name="admin_delete_subcategory")
     * @param SubCategoryRepository $repository
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function addSubCategory(SubCategoryRepository $repository, $id)
    {
        $category = $repository->find($id);

        $fileSystem = new Filesystem();
        $fileSystem->remove($this->getParameter('category_assets_dir') . '/' . $category->getPhoto());

        $em = $this->getDoctrine()->getManager();
        $em->remove($category);
        $em->flush();

        $this->addFlash('add', 'Sous-catégorie supprimé avec succès');

        return $this->redirectToRoute('admin_list_subcategory');
    }
}