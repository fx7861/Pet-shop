<?php

namespace App\Controller;


use App\Entity\User;
use App\Form\LoginType;
use App\Form\RegisterType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/register.html", name="page_register")
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function register(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $user = new User();

        $user->setRoles(['ROLE_MEMBRE']);

        $form = $this->createForm(RegisterType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user->setPassword($encoder->encodePassword($user, $user->getPassword()));

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('notice', 'Félicitation, vous pouvez vous connecter !');

            return $this->redirectToRoute('page_login');
        }

        return $this->render('security/register.html.twig', [
            'formRegister' => $form->createView()
        ]);
    }

    /**
     * @Route("/login.html", name="page_login")
     * @param AuthenticationUtils $authenticationUtils
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function login(AuthenticationUtils $authenticationUtils)
    {
        $form = $this->createForm(LoginType::class, [
            'email' => $authenticationUtils->getLastUsername()
        ]);

        $error = $authenticationUtils->getLastAuthenticationError();

        return $this->render('security/login.html.twig', [
            'form' => $form->createView(),
            'error' => $error
        ]);
    }

    /**
     * @Route("/deconnexion.html", name="page_deconnexion")
     */
    public function deconnexion() {}
}