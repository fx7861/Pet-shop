<?php

namespace App\Controller\Member;

use App\Entity\User;
use App\Form\ChangePasswordType;
use App\Form\UserType;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class MemberController extends AbstractController
{

    /**
     * @Route("/membre/dashboard.html", name="membre_dashboard")
     */
    public function dashboard()
    {
        return $this->render('member/dashboard.html.twig');
    }

    /**
     * @Route("/membre/commande.html", name="membre_commande")
     * @param ProductRepository $repository
     * @param SessionInterface $session
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function commande(ProductRepository $repository, SessionInterface $session)
    {
        $products = $repository->findByKeys(array_keys($session->get('panier')));

        return $this->render('member/commande.html.twig', [
            'products' => $products,
            'panier' => $session->get('panier')
        ]);
    }

    /**
     * @Route("/membre/order.html", name="membre_order")
     * @param OrderRepository $repository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function order(OrderRepository $repository)
    {
        /** @var User $user */
        $user = $this->getUser();

        $orders = $repository->findAllByUser($user);

        return $this->render('member/order.html.twig', [
            'orders' => $orders
        ]);
    }

    /**
     * @Route("/membre/profil.html", name="membre_profil")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function profil(Request $request)
    {
        $user = $this->getUser();

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $this->addFlash('notice', 'Profil mis à jour');

        }

        return $this->render('member/profil.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/membre/delete.html", name="membre_delete")
     * @param SessionInterface $session
     * @param TokenStorageInterface $tokenStorage
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function delete(SessionInterface $session, TokenStorageInterface $tokenStorage)
    {
        $user = $this->getUser();

        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();

        $tokenStorage->setToken(null);
        $session->invalidate();

        $this->addFlash('notice', 'Votre compte à été supprimé avec succès');

        return $this->redirectToRoute('page_home');
    }


    /**
     * @Route("/membre/password.html", name="membre_password")
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function changePassword(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $user = $this->getUser();

        $form = $this->createForm(ChangePasswordType::class)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();
            $oldPassword = $data['oldPassword'];

            if ($encoder->isPasswordValid($user, $oldPassword)) {
                $newEncodedPassword = $encoder->encodePassword($user, $data['plainPassword']);
                $user->setPassword($newEncodedPassword);

                $em = $this->getDoctrine()->getManager();
                $em->flush();

                $this->addFlash('notice', 'Mot de passe mis à jour');

                return $this->redirectToRoute('membre_dashboard');
            } else {
                $form->addError(new FormError('Ancien mot de passe incorrect'));
            }
        }

        return $this->render('member/password.html.twig', [
            'form' => $form->createView()
        ]);
    }

}