<?php

namespace App\Controller\Member;


use App\Entity\Order;
use App\Entity\Product;
use App\Entity\User;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class PaymentController extends AbstractController
{
    /**
     * @Route("/membre/paiement", name="membre_paiement")
     * @param SessionInterface $session
     * @param Request $request
     * @param ProductRepository $repository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function payment(SessionInterface $session, Request $request, ProductRepository $repository)
    {
        if ($request->request->get('stripeToken') != null) {

            $user = $this->getUser();

            $panier = $session->get('panier');

            /** @var Product $products */
            $products = $repository->findByKeys(array_keys($panier));

            $price = 0;

            foreach ($products as $p) {
                $price += $p->getPrice();
            }

            \Stripe\Stripe::setApiKey("sk_test_4eC39HqLyjWDarjtT1zdp7dc");

            $paiement = \Stripe\Charge::create([
                "amount" => $price * 100,
                "currency" => "eur",
                "source" => $request->request->get('stripeToken'), // obtained with Stripe.js
                "description" => "Paiement de " . $user->getUsername() . " " . $user->getName()
            ]);

            if ($paiement['status'] === "succeeded") {
                $order = new Order();

                $order->setUser($user);
                $order->setPrice($price);
                $order->setPayer(true);

                foreach ($products as $p) {
                    $order->addProduct($p);
                }

                $em = $this->getDoctrine()->getManager();
                $em->persist($order);
                $em->flush();

                $session->remove('panier');

                $this->addFlash('notice', 'Merci pour votre commande !');

                return $this->redirectToRoute('membre_order');
            }
        }

        return $this->render('member/paiement.html.twig');
    }
}