<?php

namespace App\Controller\Admin;

use App\Controller\HelperTrait;
use App\Form\CategoryType;
use App\Form\ProductType;
use App\Form\SubCategoryType;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use App\Repository\SubCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminEditController extends AbstractController
{

    // TODO : supprimer l'image si une nouvelle et enregistrer

    use HelperTrait;

    /**
     * @Route("/admin/product/edit/{id<\d+>}", name="admin_edit_product")
     * @param ProductRepository $repository
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addProduct(ProductRepository $repository, Request $request, $id)
    {
        $product = $repository->find($id);

        $photoOrigine = $product->getPhoto();

        $product->setPhoto(
            new File($this->getParameter('products_assets_dir') . '/' . $product->getPhoto())
        );

        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($product->getPhoto() != null) {
                /** @var UploadedFile $photo */
                $photo = $product->getPhoto();

                $fileName = $this->slugify($product->getTitle()) . '-' . $this->generateUniqueFileName() . '.' . $photo->guessExtension();
                $photo->move($this->getParameter('products_assets_dir'), $fileName);

                $product->setPhoto($fileName);
            } else {
                $product->setPhoto($photoOrigine);
            }

            $product->setSlug($this->slugify($product->getTitle()));

            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $this->addFlash('add', 'Produit modifié avec succès');

            return $this->redirectToRoute('admin_list_product');
        }

        return $this->render('admin/add/addProduct.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/category/edit/{id<\d+>}", name="admin_edit_category")
     * @param CategoryRepository $repository
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function addCategory(CategoryRepository $repository, Request $request, $id)
    {
        $category = $repository->find($id);

        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $category->setSlug($this->slugify($category->getName()));

            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $this->addFlash('add', 'Catégorie modifié avec succès');

            return $this->redirectToRoute('admin_list_category');
        }

        return $this->render('admin/add/addCategory.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/subcategory/edit/{id<\d+>}", name="admin_edit_subcategory")
     * @param SubCategoryRepository $repository
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function addSubCategory(SubCategoryRepository $repository, Request $request, $id)
    {
        $category = $repository->find($id);

        $photoOrigine = $category->getPhoto();

        $category->setPhoto(
            new File($this->getParameter('category_assets_dir') . '/' . $category->getPhoto())
        );

        $form = $this->createForm(SubCategoryType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($category->getPhoto() != null) {
                /** @var UploadedFile $photo */
                $photo = $category->getPhoto();

                $fileName = $this->slugify($category->getName()) . '-' . $this->generateUniqueFileName() . '.' . $photo->guessExtension();
                $photo->move($this->getParameter('category_assets_dir'), $fileName);

                $category->setPhoto($fileName);
            } else {
                $category->setPhoto($photoOrigine);
            }

            $category->setSlug($this->slugify($category->getName()));

            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $this->addFlash('add', 'Sous-catégorie modifié avec succès');

            return $this->redirectToRoute('admin_list_subcategory');
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