<?php

namespace App\Controller;

use App\Entity\Presence;
use App\Form\PresenceType;
use App\Repository\PresenceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/presence')]
class PresenceController extends AbstractController
{
    #[Route('info/{an}', name: 'app_presence_info', methods: ['GET'])]
    public function info(int $an,PresenceRepository $presenceRepository): Response
    {
        $id=$this->getUser()->getId();

        return $this->render('presence/index.html.twig', [
            'presences' => $presenceRepository->findBy(['annee'=>$an,'filier'=>1]),
            'id'=>$id,
        ]);
    }

    #[Route('rh/{an}', name: 'app_presence_rh', methods: ['GET'])]
    public function rh(int $an,PresenceRepository $presenceRepository): Response
    {
        $id = $this->getUser()->getId();

        return $this->render('presence/index.html.twig', [
            'presences' => $presenceRepository->findBy(['annee'=>$an,'filier'=>2]),
            'id' => $id,
        ]);
    }


    #[Route('/new', name: 'app_presence_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PresenceRepository $presenceRepository): Response
    {
        $presence = new Presence();
        $form = $this->createForm(PresenceType::class, $presence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $presenceRepository->add($presence);
            return $this->redirectToRoute('app_presence_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('presence/new.html.twig', [
            'presence' => $presence,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_presence_show', methods: ['GET'])]
    public function show(Presence $presence): Response
    {
        return $this->render('presence/show.html.twig', [
            'presence' => $presence,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_presence_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Presence $presence, PresenceRepository $presenceRepository): Response
    {
        $form = $this->createForm(PresenceType::class, $presence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $presenceRepository->add($presence);
            return $this->redirectToRoute('app_presence_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('presence/edit.html.twig', [
            'presence' => $presence,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_presence_delete', methods: ['POST'])]
    public function delete(Request $request, Presence $presence, PresenceRepository $presenceRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$presence->getId(), $request->request->get('_token'))) {
            $presenceRepository->remove($presence);
        }

        return $this->redirectToRoute('app_presence_index', [], Response::HTTP_SEE_OTHER);
    }
}
