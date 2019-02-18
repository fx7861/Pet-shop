<?php

namespace App\Controller;


use App\Entity\Product;
use App\Form\ProductType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{

    use HelperTrait;

    /**
     * @Route("/admin/product", name="admin_product")
     */
    public function listProduct(Request $request)
    {
        $product = new Product();

        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $photo = $product->getPhoto();

            $fileName = $this->slugify($product->getTitle()) . '.' . $photo->guessExtension();
            $photo->move($this->getParameter('products_assets_dir'), $fileName);

            $product->setPhoto($fileName);

            $product->setSlug($this->slugify($product->getTitle()));

            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();

        }

        return $this->render('admin/listProduct.html.twig', [
            'form' => $form->createView()
        ]);
    }
}