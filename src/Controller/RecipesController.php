<?php

namespace App\Controller;

use App\Entity\Recipes;
use App\Form\RecipesType;
use App\Repository\RecipesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RecipesController extends AbstractController
{
    #[Route('/recipes', name: 'get_recipes')]
    public function getOneUser(Request $request, RecipesRepository $recipesRepository): Response
    {
        // --> ajax MESSAGES
        if($request->get('ajax') && $request->get('recipeid')) {
            $recipe = $recipesRepository->findOneBy(['id' => $request->get('recipeid')]);
            return new JsonResponse([
                'content' => $this->renderView('partials/recipes/_recipe_info.html.twig', [
                    'recipe'=>$recipe
                ])
            ]);
        }

        return $this->render('recipes/index.html.twig', [
        ]);
    }
    #[Route('/recipes/set', name: 'set_recipes', methods: ['GET', 'POST'])]
    public function setRecipe(Request $request, EntityManagerInterface $manager): Response
    {
        $recipe = new Recipes();
        $recipe->setScore(0);
        $form = $this->createForm(RecipesType::class, $recipe);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $recipe = $form->getData();
            $this->addFlash(
                'success',
                "La recette a bien été créer."
            );
            $manager->persist($recipe);
            $manager->flush();
            return $this->redirectToRoute('app.admin');

        } elseif ( $form->isSubmitted() && !$form->isValid()) {
            dd($form->getData());
        };

        // --> ajax GET FORMULARY
        if($request->get('ajax')) {
            return new JsonResponse([
                'content' => $this->renderView('partials/recipes/_recipes_form.html.twig', [
                    'recipe'=>$recipe,
                    'form'=>$form->createView()
                ])
            ]);
        }

        return $this->render('recipes/index.html.twig', [
        ]);
    }
    #[Route('/recipes/update', name: 'update_recipes', methods: ['GET', 'POST'])]
    public function updateRecipe(Request $request, RecipesRepository $recipesRepository, EntityManagerInterface $manager): Response
    {
        $recipe = $recipesRepository->findOneBy(['id' => $request->get('recipeid')]);
        $form = $this->createForm(RecipesType::class, $recipe);
        $form->handleRequest($request);
        if($form->isSubmitted()) {
            $recipe = $form->getData();
            $this->addFlash(
                'success',
                "La recette a bien été modifier."
            );
            $manager->persist($recipe);
            $manager->flush();
            return $this->redirectToRoute('app.admin');

        } 

        // --> ajax GET FORMULARY
        if($request->get('ajax')) {
            return new JsonResponse([
                'content' => $this->renderView('partials/recipes/_recipes_update_form.html.twig', [
                    'recipe'=>$recipe,
                    'form'=>$form->createView()
                ])
            ]);
        }

        return $this->render('recipes/index.html.twig', [
        ]);
    }

    #[Route('/recipes/delete/{recipeid}', name: 'delete_recipe')]
    public function deleteUser(RecipesRepository $recipesRepository, int $recipeid, EntityManagerInterface $manager): Response
    {
        $recipe = $recipesRepository->findOneBy(["id" => $recipeid]);
        $manager->remove($recipe);
        $manager->flush();
        $this->addFlash(
            'success',
            'Recette Supprimé avec succès !'
        );
        return $this->redirectToRoute('app.admin');
    }
}
