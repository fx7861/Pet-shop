<?php

namespace App\Controller\Member;


use App\Form\PasswordType;
use App\Form\UserType;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;

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
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function delete()
    {
        $user = $this->getUser();

        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();

        $this->addFlash('notice', 'Votre compte à été supprimé avec succès');

        return $this->redirectToRoute('page_login');
    }



    /**
     * @Route("/membre/password.html", name="membre_password")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function changePassword(Request $request)
    {
        $user = $this->getUser();

        $form = $this->createForm(PasswordType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $passwordEncoder = $this->get('security.password_encoder');
            $oldPassword = $request->get('reset_password')['oldPassword'];

            if ($passwordEncoder->isPasswordValid($user, $oldPassword)) {
                $newEncodedPassword = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
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