<?php

namespace App\Controller\Etudiant;

use App\Entity\Etudiant;
use App\Form\EtudiantType;
use App\Form\EtudiantTypenew;
use App\Repository\EtudiantRepository;
use App\Repository\FilierRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
 class informatiqueController extends AbstractController
{

    #[Route('/informatique/{an}', name: 'info')]
    public function L1(EtudiantRepository $etudiantRepository,int $an): Response
    {
        return $this->render('etudiant/info/index.html.twig', [
            'etudiants' => $etudiantRepository->findBy(['annee'=>$an,'filier'=>1]),
            'an'=>$an,
        ]);
    }


     #[Route('/informatique/new/{an}', name: 'info_etudiant_new', methods: ['GET', 'POST'])]
     public function new1(int $an,Request $request, EtudiantRepository $etudiantRepository,FilierRepository $filierRepository): Response
     {
         $filier=$filierRepository->find(1);
         $etudiant = new Etudiant();
         $etudiant->setFilier($filier);
         $etudiant->setPresence(0);
         $etudiant->setAnnee($an);
         $form = $this->createForm(EtudiantTypenew::class, $etudiant);
         $form->handleRequest($request);

         if ($form->isSubmitted() && $form->isValid()) {
             $etudiantRepository->add($etudiant);
             return $this->redirect("https://127.0.0.1:8000/informatique/$an");
         }

         return $this->renderForm('etudiant/new.html.twig', [
             'etudiant' => $etudiant,
             'form' => $form,
         ]);
     }



 }
