<?php

namespace App\Controller\Page;


use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/{category<[a-zA-Z0-9\-_\/]+>}/{subCategory<[a-zA-Z0-9\-_\/]+>}/{slug<[a-zA-Z0-9\-_\/]+>}-{id<\d+>}.html",
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
}