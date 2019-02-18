<?php

namespace App\Controller;


use App\Form\ProductType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{

    /**
     * @Route("/admin/product", name="admin_product")
     */
    public function listProduct()
    {
        $form = $this->createForm(ProductType::class);

        return $this->render('admin/listProduct.html.twig', [
            'form' => $form->createView()
        ]);
    }
}