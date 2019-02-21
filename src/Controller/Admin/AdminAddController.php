<?php

namespace App\Controller\Admin;

use App\Controller\HelperTrait;
use App\Entity\Category;
use App\Entity\Product;
use App\Entity\SubCategory;
use App\Form\CategoryType;
use App\Form\ProductType;
use App\Form\SubCategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class AdminAddController extends AbstractController
{

    use HelperTrait;

    /**
     * @Route("/admin/product/add", name="admin_add_product")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addProduct(Request $request)
    {
        $product = new Product();

        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $photo */
            $photo = $product->getPhoto();

            $fileName = $this->slugify($product->getTitle()) . '-' . $this->generateUniqueFileName() . '.' . $photo->guessExtension();
            $photo->move($this->getParameter('products_assets_dir'), $fileName);

            $product->setPhoto($fileName);

            $product->setSlug($this->slugify($product->getTitle()));

            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();

            $this->addFlash('add', 'Produit ajouté avec succès');

            return $this->redirectToRoute('admin_add_product');
        }

        return $this->render('admin/add/addProduct.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/category/add", name="admin_add_category")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function addCategory(Request $request)
    {
        $category = new Category();

        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $category->setSlug($this->slugify($category->getName()));

            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            $this->addFlash('add', 'Catégorie ajouté avec succès');

            return $this->redirectToRoute('admin_add_category');
        }

        return $this->render('admin/add/addCategory.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/subcategory/add", name="admin_add_subcategory")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function addSubCategory(Request $request)
    {
        $category = new SubCategory();

        $form = $this->createForm(SubCategoryType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $photo */
            $photo = $category->getPhoto();

            $fileName = $this->slugify($category->getName()) . '-' . $this->generateUniqueFileName() . '.' . $photo->guessExtension();
            $photo->move($this->getParameter('category_assets_dir'), $fileName);

            $category->setPhoto($fileName);

            $category->setSlug($this->slugify($category->getName()));

            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            $this->addFlash('add', 'Sous-catégorie ajouté avec succès');

            return $this->redirectToRoute('admin_add_subcategory');
        }

        return $this->render('admin/add/addSubCategory.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @return string
     */
    private function generateUniqueFileName(): string
    {
        $generateUniqueId = md5(uniqid());
        return substr($generateUniqueId, 0, 10);
    }
}