<?php

namespace App\Controller;

use App\Form\CabinetType;
use App\Repository\CabinetRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CabinetController extends AbstractController
{

    #[Route('/cabinet', name: 'get_cabinet')]
    public function getOneUser(Request $request, CabinetRepository $cabinetRepository): Response
    {
        // --> ajax MESSAGES
        if($request->get('ajax') && $request->get('cabinetid')) {
            $cabinet = $cabinetRepository->findOneBy(['id' => $request->get('cabinetid')]);
            return new JsonResponse([
                'content' => $this->renderView('partials/cabinet/_cabinet_info.html.twig', [
                    'cabinet'=>$cabinet
                ])
            ]);
        }

        return $this->render('cabinet/index.html.twig', [
        ]);
    }
    #[Route('/cabinet/update', name: 'update_cabinet', methods: ['GET', 'POST'])]
    public function updateUser(Request $request, CabinetRepository $cabinetRepository, EntityManagerInterface $manager): Response
    {
        $cabinet = $cabinetRepository->findOneBy(['id' => $request->get('cabinetid')]);
        $form = $this->createForm(CabinetType::class, $cabinet);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $cabinet = $form->getData();
            $this->addFlash(
                'success',
                "Les infos du cabinet ont bien été modifier."
            );
            $manager->persist($cabinet);
            $manager->flush();
            return $this->redirectToRoute('app.admin');
        } elseif ( $form->isSubmitted() && !$form->isValid()) {
            dd($form->getData());
        };

        // --> ajax GET FORMULARY
        if($request->get('ajax') && $request->get('cabinetid')) {
            return new JsonResponse([
                'content' => $this->renderView('partials/cabinet/_cabinet_update_form.html.twig', [
                    'cabinet'=>$cabinet,
                    'form'=>$form->createView()
                ])
            ]);
        }

        return $this->render('cabinet/index.html.twig', [
        ]);
    }
}
