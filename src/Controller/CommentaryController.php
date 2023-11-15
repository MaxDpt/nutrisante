<?php

namespace App\Controller;

use App\Entity\Commentary;
use App\Form\CommentaryType;
use App\Repository\CommentaryRepository;
use App\Repository\RecipesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentaryController extends AbstractController
{
    #[Route('/commentary/get', name: 'get_commentary', methods: ['GET'])]
    public function getAll(Request $request, CommentaryRepository $commentaryRepository): Response
    {
        $recipeId = $request->get('recipeid');
        $commentarysLimit = $request->get('commentaryLimit') ? $request->get('commentaryLimit') : 4;

        if ($request->get('ajax') ) {
            $commentarys = $commentaryRepository->findPaginatedCommentaryByRecipe( $commentarysLimit, $recipeId);
            return new JsonResponse([
                'content' => $this->renderView('partials/commentary/_commentary_list.html.twig', [
                    'userConnected'=>$this->getUser(),
                    'commentarys'=>$commentarys,
                ])
            ]);
        
    }
        return $this->render('commentary/index.html.twig', [
            'controller_name' => 'CommentaryController',
        ]);
    }

    #[Route('/commentary/set', name: 'set_commentary', methods: ['GET','POST'])]
    public function set(Request $request, EntityManagerInterface $manager, RecipesRepository $recipesRepository, CommentaryRepository $commentaryRepository): Response
    {
        $recipeId = $request->get('recipeid');
        $commentarysLimit = $request->get('commentaryLimit') ? $request->get('commentaryLimit') : 4;
        // --> form view
        $commentary = new Commentary();
        $form = $this->createForm(CommentaryType::class, $commentary);
        $form->handleRequest($request);

        if ($request->get('ajax') ) {
            $commentary = $form->getData();
            $commentary
            ->setRecipe($recipesRepository->findOneby(['id' => $request->get('recipeid')]) )
            ->setName($request->get('name'))
            ->setScore($request->get('score'))
            ->setText($request->getContent());
            $manager->persist($commentary);
            $manager->flush();
            
            $commentarys = $commentaryRepository->findPaginatedCommentaryByRecipe( $commentarysLimit, $recipeId);

            return new JsonResponse([
                'content' => $this->renderView('partials/commentary/_commentary_list.html.twig', [
                    'userConnected'=>$this->getUser(),
                    'commentarys'=>$commentarys,
                ])
            ]); 
        }
        return $this->render('commentary/index.html.twig', [
            'controller_name' => 'CommentaryController',
        ]);
    }

    #[Route('/commentary/delete', name: 'delete_commentary')]
    public function deleteUser(Request $request, CommentaryRepository $commentaryRepository, EntityManagerInterface $manager): Response
    {
        $recipeId = $request->get('recipeid');
        $commentarysLimit = $request->get('commentaryLimit') ? $request->get('commentaryLimit') : 4;
        
        if ($request->get('ajax')) {
        $commentaryId = $request->get('commentaryId');
        $commentary = $commentaryRepository->findOneBy(["id" => $commentaryId]);
        $manager->remove($commentary);
        $manager->flush();

        $commentarys = $commentaryRepository->findPaginatedCommentaryByRecipe( $commentarysLimit, $recipeId);

        return new JsonResponse([
            'content' => $this->renderView('partials/commentary/_commentary_list.html.twig', [
                'userConnected'=>$this->getUser(),
                'commentarys'=>$commentarys,
            ])
        ]); 
        }
        
        return $this->redirectToRoute('app.home');
    }
}
