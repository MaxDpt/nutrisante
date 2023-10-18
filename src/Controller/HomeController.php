<?php

namespace App\Controller;

use App\Repository\CabinetRepository;
use App\Repository\RecipesRepository;
use App\Repository\ServicesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Length;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app.home')]
    public function index(Request $request,
                          RecipesRepository $recipesRepository, 
                          ServicesRepository $servicesRepository,
                          CabinetRepository $cabinetRepository): Response
    {
        $user = $this->getUser();
        $diet = null;
        $allergen = null;
        if ($user && $request->get('diet_filter')) { 
                $diet = $user->diet;
        }
        if ($user && $request->get('allergen_filter')) { 
                $allergen = $user->allergen; 
        }
        $search = $request->get('search') ? $request->get('search') : null;
        /* --- RECIPES --- */
        $recipesLimit = 8;
        $recipesPage = $request->get("recipesListPage") ? $request->get("recipesListPage") : 1;
        $recipes = $recipesRepository->findAllPaginatedRecipes($recipesPage, $recipesLimit, $diet, $allergen, $search);
        $totalRecipes = $recipesRepository->getTotalRecipes($diet, $allergen, $search);
        /* --- SERVICES --- */
        $servicesLimit = 4;
        $servicesPage = $request->get("servicesListPage") ? $request->get("servicesListPage") : 1;
        $services = $servicesRepository->findAllPaginatedServices($servicesPage, $servicesLimit);
        $totalservices = $servicesRepository->getTotalServices();
        /* --- CABINET ---*/
        $cabinet = $cabinetRepository->findAll();

        /* ---------- NAVIGATION ---------- */
        // --> ajax RECETTES
        if($request->get('ajax') && $request->get('window') == 'recipe') {
            return new JsonResponse([
                'content' => $this->renderView('partials/home/_recettes_page.html.twig', [
                    'recipes' => $recipes,
                    'totalRecipes' => $totalRecipes,
                    'recipesLimit' => $recipesLimit,
                ])
            ]);
        }
        // --> ajax SERVICES
        if($request->get('ajax') && $request->get('window') == 'service') {
            return new JsonResponse([
                'content' => $this->renderView('partials/home/_services_page.html.twig', [
                    'services' => $services,
                    'totalservices' => $totalservices,
                    'servicesLimit' => $servicesLimit,
                ])
            ]);
        }
        // --> ajax INFOS
        if($request->get('ajax') && $request->get('window') == 'info') {
            return new JsonResponse([
                'content' => $this->renderView('partials/home/_infos_page.html.twig', [
                    'cabinet'=> $cabinet
                ])
            ]);
        }

        /* ---------- PAGINATION ---------- */
        // --> ajax RECIPE TABLE
        if($request->get('ajax') && $request->get('recipesListPage')) {
            return new JsonResponse([
                'totalRecipes' => $totalRecipes,
                'recipesLimit' => $recipesLimit,
                'content' => $this->renderView('partials/recipes/_recipes_list.html.twig', [
                    'recipes' => $recipes,
                    'totalRecipes' => $totalRecipes,
                    'recipesLimit' => $recipesLimit,
                ])
            ]);
        }
        // --> ajax SERVICE TABLE
        if($request->get('ajax') && $request->get('servicesListPage')) {
            return new JsonResponse([
                'totalservices' => $totalservices,
                'servicesLimit' => $servicesLimit,
                'content' => $this->renderView('partials/services/_services_list.html.twig', [
                    'services' => $services,
                    'totalservices' => $totalservices,
                    'servicesLimit' => $servicesLimit,
                ])
            ]);
        }
        /* ---------- FILTRAGE ---------- */
        if($request->get('ajax') && $request->get('diet_filter') || 
           $request->get('ajax') && $request->get('allergen_filter')) {
            return new JsonResponse([
                'totalRecipes' => $totalRecipes,
                'recipesLimit' => $recipesLimit,
                'content' => $this->renderView('partials/recipes/_recipes_list.html.twig', [
                    'recipes' => $recipes,
                    'totalRecipes' => $totalRecipes,
                    'recipesLimit' => $recipesLimit,
                ])
            ]);
        }
        if($request->get('ajax') && $request->get('filters') == 'null') {
         return new JsonResponse([
            'totalRecipes' => $totalRecipes,
            'recipesLimit' => $recipesLimit,
             'content' => $this->renderView('partials/recipes/_recipes_list.html.twig', [
                 'recipes' => $recipes,
                 'totalRecipes' => $totalRecipes,
                 'recipesLimit' => $recipesLimit,
             ])
         ]);
     }
        /* ---------- RECHERCHE ---------- */
        if($request->get('ajax') && $request->get('search')) {
         return new JsonResponse([
             'totalRecipes' => $totalRecipes,
             'recipesLimit' => $recipesLimit,
             'content' => $this->renderView('partials/recipes/_recipes_list.html.twig', [
                 'recipes' => $recipes,
                 'totalRecipes' => $totalRecipes,
                 'recipesLimit' => $recipesLimit,
             ])
         ]);
     }

        // --> HOME PAGE
        return $this->render('pages/home_page.html.twig', [
            'recipes' => $recipes,
            'totalRecipes' => $totalRecipes,
            'recipesLimit' => $recipesLimit,
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
