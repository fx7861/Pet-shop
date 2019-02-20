<?php

namespace App\Controller\Admin;



use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin/dashboard", name="admin_dashboard")
     */
    public function dashboard()
    {
        return $this->render('admin/dashboard/dashboard.html.twig');
    }
}