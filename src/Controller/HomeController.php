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

class HomeController extends AbstractController
{
    #[Route('/', name: 'app.home')]
    public function index(Request $request,
                          RecipesRepository $recipesRepository, 
                          ServicesRepository $servicesRepository,
                          CabinetRepository $cabinetRepository): Response
    {
        $user = $this->getUser();
        $diet = $user && $user->roles[0] !== 'ROLE_ADMINISTRATOR' ? $user->diet : null;
        $allergen = $user && $user->roles[0] !== 'ROLE_ADMINISTRATOR' ? $user->allergen : null;
        $userId = $user && $user->roles[0] !== 'ROLE_ADMINISTRATOR' ? $user->id : null;
        $search = $request->get('search') && $request->get('search') !== 'null' ? $request->get('search') : null;

        if ($user && $request->get('diet_filter') === 'false') { 
            $diet = null;
        }
        if ($user && $request->get('allergen_filter') === 'false') { 
            $allergen = null; 
        }
        if ($user && $request->get('recette_filter') === 'false') { 
            $userId = null; 
        }
        if ($user && $request->get('filters') === 'null') { 
            $diet = null;
            $allergen = null; 
            $userId = null; 
        }

        /* --- RECIPES --- */
        $recipesLimit = 8;
        $recipesPage = $request->get("recipesListPage") ? $request->get("recipesListPage") : 1;
        if ($user && $user->roles[0] === 'ROLE_ADMINISTRATOR' ) {
            $recipes = $recipesRepository->findAllPaginatedRecipesAdmin($recipesPage, $recipesLimit );
            $totalRecipes = $recipesRepository->getTotalRecipesAdmin();   
        } else {
            $recipes = $recipesRepository->findAllPaginatedRecipes($recipesPage, $recipesLimit, $diet, $allergen, $search, $userId);
            $totalRecipes = $recipesRepository->getTotalRecipes($diet, $allergen, $search, $userId); }
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
                    'userConnected' => $this->getUser(),
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
                    'userConnected' => $this->getUser(),
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
                    'userConnected' => $this->getUser(),
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
                    'userConnected' => $this->getUser(),
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
                    'userConnected' => $this->getUser(),
                    'services' => $services,
                    'totalservices' => $totalservices,
                    'servicesLimit' => $servicesLimit,
                ])
            ]);
        }
        /* ---------- FILTRAGE ---------- */
        if($request->get('ajax') && $request->get('diet_filter') || 
           $request->get('ajax') && $request->get('allergen_filter') || 
           $request->get('ajax') && $request->get('recette_filter')) {
            return new JsonResponse([
                'totalRecipes' => $totalRecipes,
                'recipesLimit' => $recipesLimit,
                'content' => $this->renderView('partials/recipes/_recipes_list.html.twig', [
                    'userConnected' => $this->getUser(),
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
                'userConnected' => $this->getUser(),
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
                'userConnected' => $this->getUser(),
                 'recipes' => $recipes,
                 'totalRecipes' => $totalRecipes,
                 'recipesLimit' => $recipesLimit,
             ])
         ]);
     }

        // --> HOME PAGE
        return $this->render('pages/home_page.html.twig', [
            'userConnected' => $this->getUser(),
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
            'userConnected' => $this->getUser(),
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/privacyPolicy', name: 'app.privacyPolicy')]
    public function privacyPolicy(): Response
    {
        // --> PRIVACY POLICY PAGE
        return $this->render('pages/privacyPolicy_page.html.twig', [
            'userConnected' => $this->getUser(),
            'controller_name' => 'HomeController',
        ]);
    }
}
