<?php

namespace App\Controller\liste;

use App\Entity\Presence;
use App\Form\PresenceType;
use App\Repository\EtudiantRepository;
use App\Repository\FilierRepository;
use App\Repository\PresenceRepository;
use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class listeinfoController extends AbstractController
{
    #[Route('/listinfo/{an}', name: 'app_list_info')]
    public function list(int $an,SessionInterface $session,EtudiantRepository $etudiantRepository): Response
    {
        $session->remove('data');
        $session->remove('list');
        $etudiant=$etudiantRepository->findBy(['annee'=>$an,'filier'=>1]);
        $list=$session->get('list',[]);
        foreach ($etudiant as $etudiants){
            $list[$etudiants->getId()]=0;
        }
        $session->set("list",$list);
        return $this->redirectToRoute('app_prof',compact("an"));
    }
 #[Route('/envoiinfo/{an}', name: 'app_envoi_info')]
    public function evoi(int $an,SessionInterface $session,PresenceRepository $presenceRepository,Request $request,UsersRepository $repository,FilierRepository $filierRepository): Response
    {
        $id=$this->getUser()->getId();
        $prof=$repository->find($id);
        $filier=$filierRepository->find(1);
        $list=$session->get('data');
        $presence = new Presence();
        $presence->setUser($prof);
        $presence->setPresent($list);
        $presence->setAnnee($an);
        $presence->setFilier($filier);


            $presenceRepository->add($presence);

        $this->addFlash('success','La liste a bien ete envoyer');


        return $this->redirectToRoute('app_prof',compact("an"));
    }

}
