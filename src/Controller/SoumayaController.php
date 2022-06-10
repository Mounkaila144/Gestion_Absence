<?php

namespace App\Controller;

use App\Entity\Etudiant;
use App\Form\SoumayaType;
use App\Repository\EtudiantRepository;
use App\Repository\FilierRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class SoumayaController extends AbstractController
{
    #[Route('/soumaya', name: 'app_soumaya')]
    public function index(Request $request,SessionInterface $session,
                          FilierRepository $filierRepository,EtudiantRepository $etudiantRepository): Response
    {

        $form = $this->createForm(SoumayaType::class);
        $data = $form->handleRequest($request);
        $filler=$filierRepository->findOneBy(['id'=>1]);

        if ($form->isSubmitted() && $form->isValid()) {
           $etud=new Etudiant();
           $etud->setNom('fff');
           $etud->setNumero(11);
           $etud->setPrenom('rr');
           $etud->setFilier($filler);
           $etudiantRepository->add($etud);
        }

        return $this->render('soumaya/index.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/soumaya1', name: 'app_soumaya1')]
    public function index1(Request $request,SessionInterface $session): Response
    {

             dd($session->get('valeur'));

        return $this->render('soumaya/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
