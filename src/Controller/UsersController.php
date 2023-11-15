<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UsersType;
use App\Form\UsersUpdateType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UsersController extends AbstractController
{
    #[Route('/user', name: 'get_user')]
    public function getOneUser(Request $request, UserRepository $userRepository): Response
    {
        // --> ajax MESSAGES
        if($request->get('ajax') && $request->get('userid')) {
            $user = $userRepository->findOneBy(['id' => $request->get('userid')]);
            return new JsonResponse([
                'content' => $this->renderView('partials/users/_user_info.html.twig', [
                    'user'=>$user
                ])
            ]);
        }

        return $this->render('users/index.html.twig', [
        ]);
    }
    #[Route('/users/search', name: 'get_user_search')]
    public function getUsersSearch(Request $request, UserRepository $userRepository): Response
    {
        // --> ajax MESSAGES
        if($request->get('ajax') && $request->get('userSearch')) {
            $userSearch = $request->get('userSearch');
            $users = $userRepository->findAllUsersSearch($userSearch);
            return new JsonResponse([
                'content' => $this->renderView('partials/recipes/partials/_itemResult_Search.html.twig', [
                    'users'=>$users
                ])
            ]);
        } 
        if ($request->get('ajax') && !$request->get('userSearch')){
            $users = null;
            return new JsonResponse([
                'content' => $this->renderView('partials/recipes/partials/_itemResult_Search.html.twig', [
                    'users'=>$users
                ])
            ]);
        }

        return $this->render('users/index.html.twig', [
        ]);
    }
    #[Route('/user/set', name: 'set_user', methods: ['GET', 'POST'])]
    public function setUser(Request $request, EntityManagerInterface $manager): Response
    {
        $user = new User();
        $user->setRoles(['ROLE_USER']);
        $form = $this->createForm(UsersType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $this->addFlash(
                'success',
                "L'utilisateur a bien été créer."
            );
            $manager->persist($user);
            $manager->flush();
            return $this->redirectToRoute('app.admin');

        } elseif ( $form->isSubmitted() && !$form->isValid()) {
            dd($form->getData());
        };

        // --> ajax GET FORMULARY
        if($request->get('ajax')) {
            return new JsonResponse([
                'content' => $this->renderView('partials/users/_users_form.html.twig', [
                    'user'=>$user,
                    'form'=>$form->createView()
                ])
            ]);
        }

        return $this->render('users/index.html.twig', [
        ]);
    }
    #[Route('/user/update', name: 'update_user', methods: ['GET', 'POST'])]
    public function updateUser(Request $request, UserRepository $userRepository, EntityManagerInterface $manager): Response
    {
        $user = $userRepository->findOneBy(['id' => $request->get('userid')]);
        $form = $this->createForm(UsersUpdateType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $this->addFlash(
                'success',
                "L'utilisateur a bien été modifier."
            );
            $manager->persist($user);
            $manager->flush();
            return $this->redirectToRoute('app.admin');
        } elseif ( $form->isSubmitted() && !$form->isValid()) {
            dd($form->getData());
        };

        // --> ajax GET FORMULARY
        if($request->get('ajax') && $request->get('userid')) {
            return new JsonResponse([
                'content' => $this->renderView('partials/users/_users_update_form.html.twig', [
                    'user'=>$user,
                    'form'=>$form->createView()
                ])
            ]);
        }

        return $this->render('users/index.html.twig', [
        ]);
    }
    #[Route('/user/delete/{userid}', name: 'delete_user')]
    public function deleteUser(UserRepository $userRepository, int $userid, EntityManagerInterface $manager): Response
    {
        $user = $userRepository->findOneBy(["id" => $userid]);
        $manager->remove($user);
        $manager->flush();
        $this->addFlash(
            'success',
            'Utilisateur Supprimé avec succès !'
        );
        return $this->redirectToRoute('app.admin');
    }
}
