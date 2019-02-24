<?php

namespace App\Controller\Member;

use App\Controller\Page\ProductController;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

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
     * @Route("/membre/profil.html", name="membre_profil")
     * @param UserInterface $user
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function profil(UserInterface $user, Request $request)
    {
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
     * @Route("/membre/delete", name="membre_delete")
     * @param UserInterface $user
     * @param UserRepository $repository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function delete(UserInterface $user)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();

        $this->addFlash('notice', 'Votre compte à été supprimé avec succès');

        return $this->redirectToRoute('page_login');
    }



    /**
     * @Route("/membre/password", name="membre_password")
     * @param UserInterface $user
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
    public function changePassword(UserInterface $user, Request $request)
    {

        $form = $this->createForm(PasswordType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {



            //$em = $this->getDoctrine()->getManager();
            //$em->flush();

            $this->addFlash('notice', 'Mot de passe mis à jour');

        }

        return $this->render('member/password.html.twig', [
            'form' => $form->createView()
        ]);
    }*/

}