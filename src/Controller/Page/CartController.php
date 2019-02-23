<?php

namespace App\Controller\Page;


use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{

    private $session;

    /**
     * CartController constructor.
     * @param $session
     */
    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * @Route("/panier.html", name="page_panier")
     */
    public function cart(ProductRepository $repository)
    {
        if (!$this->session->has('panier')) {
            $this->session->set('panier', []);
        }

        $products = $repository->findByKeys(array_keys($this->session->get('panier')));

        return $this->render('page/cart.html.twig', [
            'products' => $products,
            'panier' => $this->session->get('panier')
        ]);
    }

    /**
     * @Route("/panier/add/{id<\d+>}", name="add_panier")
     */
    public function addCart($id, Request $request)
    {
        if (!$this->session->has('panier')) {
            $this->session->set('panier', []);
        }

        $panier = $this->session->get('panier');

        if (array_key_exists($id, $panier)) {
            if ($request->get('qte') != null) {
                $panier[$id] += $request->get('qte');
            } else {
                $panier[$id] += 1;
            }
        } else {
            if ($request->get('qte') != null) {
                $panier[$id] = $request->get('qte');
            } else {
                $panier[$id] = 1;
            }
        }

        $this->session->set('panier', $panier);


        return $this->redirect($request->get('redirect'));

    }

    /**
     * @Route("/panier/delete/{id<\d+>}", name="delete_panier")
     */
    public function deleteCart($id)
    {

        $panier = $this->session->get('panier');

        if (array_key_exists($id, $panier)) {
            unset($panier[$id]);
            $this->session->set('panier', $panier);
        }

        return $this->redirectToRoute('page_panier');

    }


}