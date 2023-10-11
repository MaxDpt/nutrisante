<?php

namespace App\Controller;

use App\Repository\RecipesRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app.admin')]
    public function index(
                            Request $request, 
                            UserRepository $userRepository,
                            RecipesRepository $recipesRepository): Response
    {
        /* --- USERS --- */
        $usersLimit = 8;
        $usersPage = $request->get("userTablePage") ? $request->get("userTablePage") : 1;
        $users = $userRepository->findAllPaginatedUsers($usersPage, $usersLimit);
        $totalUsers = $userRepository->getTotalUsers();
        /* --- RECIPES --- */
        $recipesLimit = 8;
        $recipesPage = $request->get("recipesTablePage") ? $request->get("recipesTablePage") : 1;
        $recipes = $recipesRepository->findAllPaginatedRecipes($recipesPage, $recipesLimit);
        $totalRecipes = $recipesRepository->getTotalRecipes();

        /* ---------- NAVIGATION ---------- */
        // --> ajax GESTION
        if($request->get('ajax') && $request->get('pageValue') == 1) {
            return new JsonResponse([
                'content' => $this->renderView('partials/admin/_gestion_page.html.twig', [
                    'users' => $users,
                    'totalUsers' => $totalUsers,
                    'usersLimit' => $usersLimit,
                    'recipes' => $recipes,
                    'totalRecipes' => $totalRecipes,
                    'recipesLimit' => $recipesLimit,
                ])
            ]);
        }
        // --> ajax MESSAGES
        if($request->get('ajax') && $request->get('pageValue') == 2) {
            return new JsonResponse([
                'content' => $this->renderView('partials/admin/_messages_page.html.twig', [
                ])
            ]);
        }

        /* ---------- PAGINATION ---------- */
        // --> ajax USER TABLE
        if($request->get('ajax') && $request->get('userTablePage')) {
            return new JsonResponse([
                'content' => $this->renderView('partials/users/_users_table.html.twig', [
                    'users' => $users,
                    'totalUsers' => $totalUsers,
                    'usersLimit' => $usersLimit,
                    'recipes' => $recipes,
                    'totalRecipes' => $totalRecipes,
                    'recipesLimit' => $recipesLimit,
                ])
            ]);
        }
        // --> ajax RECIPE TABLE
        if($request->get('ajax') && $request->get('recipesTablePage')) {
            return new JsonResponse([
                'content' => $this->renderView('partials/recipes/_recipes_table.html.twig', [
                    'users' => $users,
                    'totalUsers' => $totalUsers,
                    'usersLimit' => $usersLimit,
                    'recipes' => $recipes,
                    'totalRecipes' => $totalRecipes,
                    'recipesLimit' => $recipesLimit,
                ])
            ]);
        }

        return $this->render('pages/admin_page.html.twig', [
            'users' => $users,
            'totalUsers' => $totalUsers,
            'usersLimit' => $usersLimit,
            'recipes' => $recipes,
            'totalRecipes' => $totalRecipes,
            'recipesLimit' => $recipesLimit,
        ]);
    }
}
