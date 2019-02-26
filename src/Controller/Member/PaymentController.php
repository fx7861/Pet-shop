<?php

namespace App\Controller\Member;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PaymentController extends AbstractController
{
    /**
     * @Route("/membre/paiement", name="membre_paiement")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function payment(Request $request)
    {
        if ($request->request->get('stripeToken') != null) {
            $user = $this->getUser();

            \Stripe\Stripe::setApiKey("sk_test_4eC39HqLyjWDarjtT1zdp7dc");

            $paiement = \Stripe\Charge::create([
                "amount" => 2000,
                "currency" => "eur",
                "source" => $request->request->get('stripeToken'), // obtained with Stripe.js
                "description" => "Paiement de " . $user->getUsername() . " " . $user->getName()
            ]);

            if ($paiement['status'] === "succeeded") {

                //new ommande
                //créer entity commande
                // id - de la commande
                // user_id - id de l'utilisateur
                // array product_ids
                // prix ttc
                // date de la commande
                // payer?

                // suppression du panier
                // redirect vers page de remerciment

                //page remerciment:
                //recupere les informations de la commande
                // puis un bouton vers le profil des commnde du lutilisateur
            }
        }

        return $this->render('member/paiement.html.twig');
    }
}