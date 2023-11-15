<?php

namespace App\Controller;

use App\Entity\Services;
use App\Form\ServicesType;
use App\Repository\ServicesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ServicesController extends AbstractController
{
#[Route('/service', name: 'get_service')]
public function getOneUser(Request $request, ServicesRepository $servicesRepository): Response
{
    // --> ajax MESSAGES
    if($request->get('ajax') && $request->get('serviceid')) {
        $service = $servicesRepository->findOneBy(['id' => $request->get('serviceid')]);
        return new JsonResponse([
            'content' => $this->renderView('partials/services/_service_info.html.twig', [
                'service'=>$service
            ])
        ]);
    }
    return $this->render('services/index.html.twig', [
    ]);
}
#[Route('/service/set', name: 'set_service', methods: ['GET', 'POST'])]
public function setUser(Request $request, EntityManagerInterface $manager): Response
{
    $service = new Services();
    $form = $this->createForm(ServicesType::class, $service);
    $form->handleRequest($request);
    if($form->isSubmitted() && $form->isValid()) {
        $service = $form->getData();
        $this->addFlash(
            'success',
            "Le service a bien été créer."
        );
        $manager->persist($service);
        $manager->flush();
        return $this->redirectToRoute('app.admin');
    }
    // --> ajax GET FORMULARY
    if($request->get('ajax')) {
        return new JsonResponse([
            'content' => $this->renderView('partials/services/_services_form.html.twig', [
                'form'=>$form->createView()
            ])
        ]);
    }

    return $this->render('services/index.html.twig', [
    ]);
}
#[Route('/service/update', name: 'update_service', methods: ['GET', 'POST'])]
public function updateUser(Request $request, ServicesRepository $servicesRepository, EntityManagerInterface $manager): Response
{
    $service = $servicesRepository->findOneBy(['id' => $request->get('serviceid')]);
    $form = $this->createForm(ServicesType::class, $service);
    $form->handleRequest($request);
    if($form->isSubmitted() && $form->isValid()) {
        $service = $form->getData();
        $this->addFlash(
            'success',
            "Le service a bien été modifier."
        );
        $manager->persist($service);
        $manager->flush();
        return $this->redirectToRoute('app.admin');
    }
    // --> ajax GET FORMULARY
    if($request->get('ajax')) {
        return new JsonResponse([
            'content' => $this->renderView('partials/services/_services_form.html.twig', [
                'service'=>$service,
                'form'=>$form->createView()
            ])
        ]);
    }
    return $this->render('services/index.html.twig', [
    ]);
}
#[Route('/service/delete/{serviceid}', name: 'delete_service')]
public function deleteUser(ServicesRepository $servicesRepository, int $serviceid, 
                           EntityManagerInterface $manager): Response
{
    $service = $servicesRepository->findOneBy(["id" => $serviceid]);
    $manager->remove($service);
    $manager->flush();
    $this->addFlash(
        'success',
        'Service Supprimé avec succès !'
    );
    return $this->redirectToRoute('app.admin');
}
}
