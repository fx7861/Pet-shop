<?php

namespace App\Controller;


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

class AdminController extends AbstractController
{

    use HelperTrait;

    /**
     * @Route("/admin/dashboard", name="admin_dashboard")
     */
    public function dashboard()
    {
        return $this->render('admin/dashboard/dashboard.html.twig');
    }

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

            $fileName = $this->slugify($product->getTitle()) . '.' . $photo->guessExtension();
            $photo->move($this->getParameter('products_assets_dir'), $fileName);

            $product->setPhoto($fileName);

            $product->setSlug($this->slugify($product->getTitle()));

            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();

            return $this->redirectToRoute('admin_add_product');
        }

        return $this->render('admin/addProduct.html.twig', [
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

            return $this->redirectToRoute('admin_add_category');
        }

        return $this->render('admin/addCategory.html.twig', [
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

            $fileName = $this->slugify($category->getName()) . '.' . $photo->guessExtension();
            $photo->move($this->getParameter('category_assets_dir'), $fileName);

            $category->setPhoto($fileName);

            $category->setSlug($this->slugify($category->getName()));

            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            return $this->redirectToRoute('admin_add_subcategory');
        }

        return $this->render('admin/addSubCategory.html.twig', [
            'form' => $form->createView()
        ]);
    }

}