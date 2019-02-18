<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{

    /**
     * @Route("/admin/product", name="admin_product")
     */
    public function listProduct()
    {
        // liste de produit
    }
}