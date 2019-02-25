<?php

namespace App\Controller\Page;


use App\Entity\Product;
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

        $suggestions = $repository->findProductSuggestions($product->getSubCategory()->getId());

        return $this->render('page/product.html.twig', [
            'product' => $product,
            'suggestions' => $suggestions
        ]);
    }

    /**
     * @Route("/marque/{slug<[a-zA-Z0-9\-]+>}.html", name="page_brand")
     * @param $slug
     * @return Response
     */
    public function brandCategory($slug)
    {
        $products = $this->getDoctrine()
            ->getRepository(Product::class)
            ->findByBrand($slug);

        return $this->render('page/marque.html.twig', [
            'brand' => $slug,
            'products' => $products
        ]);
    }

}