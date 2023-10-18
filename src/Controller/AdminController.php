<?php

namespace App\Controller;

use App\Repository\CabinetRepository;
use App\Repository\ContactRepository;
use App\Repository\RecipesRepository;
use App\Repository\ServicesRepository;
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
                            RecipesRepository $recipesRepository,
                            ServicesRepository $servicesRepository,
                            ContactRepository $contactRepository,
                            CabinetRepository $cabinetRepository): Response
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
        /* --- SERVICES --- */
        $servicesLimit = 8;
        $servicesPage = $request->get("servicesTablePage") ? $request->get("servicesTablePage") : 1;
        $services = $servicesRepository->findAllPaginatedServices($servicesPage, $servicesLimit);
        $totalservices = $servicesRepository->getTotalServices();
        /* --- MESSAGES --- */
        $messagesLimit = 14;
        $messagesPage = $request->get("messagesTablePage") ? $request->get("messagesTablePage") : 1;
        $messages = $contactRepository->findAllPaginatedMessages($messagesPage, $messagesLimit);
        $totalmessages = $contactRepository->getTotalMessages();
        /* --- CABINET ---*/
        $cabinet = $cabinetRepository->findAll();

        /* ---------- NAVIGATION ---------- */
        // --> ajax GESTION
        if($request->get('ajax') && $request->get('window') == 'gestion') {
            return new JsonResponse([
                'content' => $this->renderView('partials/admin/_gestion_page.html.twig', [
                    'cabinet' => $cabinet,
                    'users' => $users,
                    'totalUsers' => $totalUsers,
                    'usersLimit' => $usersLimit,
                    'recipes' => $recipes,
                    'totalRecipes' => $totalRecipes,
                    'recipesLimit' => $recipesLimit,
                    'services' => $services,
                    'totalservices' => $totalservices,
                    'servicesLimit' => $servicesLimit,
                ])
            ]);
        }
        // --> ajax MESSAGES
        if($request->get('ajax') && $request->get('window') == 'messages') {
            return new JsonResponse([
                'content' => $this->renderView('partials/admin/_messages_page.html.twig', [
                    'messages' => $messages,
                    'totalmessages' => $totalmessages,
                    'messagesLimit' => $messagesLimit,
                ])
            ]);
        }

        /* ---------- PAGINATION ---------- */
        // --> ajax USER TABLE
        if($request->get('ajax') && $request->get('userTablePage')) {
            return new JsonResponse([
                'totalUsers' => $totalUsers,
                'usersLimit' => $usersLimit,
                'content' => $this->renderView('partials/users/_users_table.html.twig', [
                    'cabinet' => $cabinet,
                    'users' => $users,
                    'totalUsers' => $totalUsers,
                    'usersLimit' => $usersLimit,
                    'recipes' => $recipes,
                    'totalRecipes' => $totalRecipes,
                    'recipesLimit' => $recipesLimit,
                    'services' => $services,
                    'totalservices' => $totalservices,
                    'servicesLimit' => $servicesLimit,
                ])
            ]);
        }
        // --> ajax RECIPE TABLE
        if($request->get('ajax') && $request->get('recipesTablePage')) {
            return new JsonResponse([
                'totalRecipes' => $totalRecipes,
                'recipesLimit' => $recipesLimit,
                'content' => $this->renderView('partials/recipes/_recipes_table.html.twig', [
                    'cabinet' => $cabinet,
                    'users' => $users,
                    'totalUsers' => $totalUsers,
                    'usersLimit' => $usersLimit,
                    'recipes' => $recipes,
                    'totalRecipes' => $totalRecipes,
                    'recipesLimit' => $recipesLimit,
                    'services' => $services,
                    'totalservices' => $totalservices,
                    'servicesLimit' => $servicesLimit,
                ])
            ]);
        }
        // --> ajax SERVICE TABLE
        if($request->get('ajax') && $request->get('servicesTablePage')) {
            return new JsonResponse([
                'totalservices' => $totalservices,
                'servicesLimit' => $servicesLimit,
                'content' => $this->renderView('partials/services/_services_table.html.twig', [
                    'cabinet' => $cabinet,
                    'users' => $users,
                    'totalUsers' => $totalUsers,
                    'usersLimit' => $usersLimit,
                    'recipes' => $recipes,
                    'totalRecipes' => $totalRecipes,
                    'recipesLimit' => $recipesLimit,
                    'services' => $services,
                    'totalservices' => $totalservices,
                    'servicesLimit' => $servicesLimit,
                ])
            ]);
        }
        // --> ajax MESSAGES TABLE
        if($request->get('ajax') && $request->get('messagesTablePage')) {
            return new JsonResponse([
                'totalmessages' => $totalmessages,
                'messagesLimit' => $messagesLimit,
                'content' => $this->renderView('partials/messages/_messages_table.html.twig', [
                    'messages' => $messages,
                    'totalmessages' => $totalmessages,
                    'messagesLimit' => $messagesLimit,
                ])
            ]);
        }

        return $this->render('pages/admin_page.html.twig', [
            'cabinet' => $cabinet,
            'users' => $users,
            'totalUsers' => $totalUsers,
            'usersLimit' => $usersLimit,
            'recipes' => $recipes,
            'totalRecipes' => $totalRecipes,
            'recipesLimit' => $recipesLimit,
            'services' => $services,
            'totalservices' => $totalservices,
            'servicesLimit' => $servicesLimit,
        ]);
    }
}
