<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactsType;
use App\Repository\ContactRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactsController extends AbstractController
{
#[Route('/message', name: 'get_message')]
public function getOneMessage(Request $request, ContactRepository $contactRepository): Response
{
    // --> ajax MESSAGES
    if($request->get('ajax') && $request->get('messageid')) {
        $message = $contactRepository->findOneBy(['id' => $request->get('messageid')]);
        return new JsonResponse([
            'content' => $this->renderView('partials/messages/_messages_info.html.twig', [
                'message'=>$message
            ])
        ]);
    }
    return $this->render('contacts/index.html.twig', [
    ]);
}
#[Route('/message/set', name: 'set_message', methods: ['GET', 'POST'])]
public function setUser(Request $request, EntityManagerInterface $manager): Response
{
    $message = new Contact();
    $form = $this->createForm(ContactsType::class, $message);
    $form->handleRequest($request);
    if($form->isSubmitted() && $form->isValid()) {
        $message = $form->getData();
        $this->addFlash(
            'success',
            "Le message a été envoyé avec succès."
        );
        $manager->persist($message);
        $manager->flush();
        return $this->redirectToRoute('app.admin');
    }

    return $this->render('pages/contact_page.html.twig', [
        'form'=>$form->createView()
    ]);
}
#[Route('/message/delete/{messageid}', name: 'delete_message')]
public function deleteMessage(ContactRepository $contactRepository, int $messageid, EntityManagerInterface $manager): Response
{
    $message = $contactRepository->findOneBy(["id" => $messageid]);
    $manager->remove($message);
    $manager->flush();
    $this->addFlash(
        'success',
        'Message Supprimé avec succès !'
    );
    return $this->redirectToRoute('app.admin');
}
}
