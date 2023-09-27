<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app.home')]
    public function index(Request $request): Response
    {

        /* ---------- NAVIGATION ---------- */
        // --> ajax RECETTES
        if($request->get('ajax') && $request->get('pageValue') == 1) {
            return new JsonResponse([
                'content' => $this->renderView('partials/home/_recettes_page.html.twig', [
                ])
            ]);
        }
        // --> ajax SERVICES
        if($request->get('ajax') && $request->get('pageValue') == 2) {
            return new JsonResponse([
                'content' => $this->renderView('partials/home/_services_page.html.twig', [
                ])
            ]);
        }
        // --> ajax INFOS
        if($request->get('ajax') && $request->get('pageValue') == 3) {
            return new JsonResponse([
                'content' => $this->renderView('partials/home/_infos_page.html.twig', [
                ])
            ]);
        }

        // --> HOME PAGE
        return $this->render('pages/home_page.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/legalNotice', name: 'app.legalNotice')]
    public function legalNotice(): Response
    {
        // --> LEGAL NOTICE PAGE
        return $this->render('pages/legalNotice_page.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/privacyPolicy', name: 'app.privacyPolicy')]
    public function privacyPolicy(): Response
    {
        // --> PRIVACY POLICY PAGE
        return $this->render('pages/privacyPolicy_page.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
