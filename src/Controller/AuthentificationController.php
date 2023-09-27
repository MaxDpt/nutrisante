<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthentificationController extends AbstractController
{
    #[Route('/login', name: 'app.login')]
    public function index(): Response
    {
        return $this->render('pages/login_page.html.twig', [
            'controller_name' => 'AuthentificationController',
        ]);
    }
}
