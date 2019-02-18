<?php

namespace App\Controller;

use App\Form\LoginType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login.html", name="page_login")
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
}