<?php

namespace App\Controller\Page;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{

    /**
     * @Route("/panier.html", name="page_panier")
     */
    public function panier() {
        return $this->render('page/cart.html.twig');
    }

    /**
     * @Route("/panier/add/{id<\d+>})
     */
    public function addPanier($id)
    {

    }

    /**
     * @Route("/panier/delete/{id<\d+>})
     */
    public function deletePanier($id)
    {

    }


}