<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app.admin')]
    public function index(Request $request): Response
    {
        /* ---------- NAVIGATION ---------- */
        // --> ajax RECETTES
        if($request->get('ajax') && $request->get('pageValue') == 1) {
            return new JsonResponse([
                'content' => $this->renderView('partials/admin/_gestion_page.html.twig', [
                ])
            ]);
        }
        // --> ajax SERVICES
        if($request->get('ajax') && $request->get('pageValue') == 2) {
            return new JsonResponse([
                'content' => $this->renderView('partials/admin/_messages_page.html.twig', [
                ])
            ]);
        }

        return $this->render('pages/admin_page.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
}
