<?php

namespace App\Controller;

use App\Entity\Presence;
use App\Form\PresenceType;
use App\Repository\EtudiantRepository;
use App\Repository\PresenceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class ProfController extends AbstractController
{
    #[Route('/prof/{an}', name: 'app_prof')]
    public function index(int $an,SessionInterface $session,EtudiantRepository $etudiantRepository): Response
    {
        $etud=$session->get("list",[]);
        $data=[];
        $send=[];
        foreach ($etud as $id=>$presence){
            $info=$etudiantRepository->find($id);
            if ($info==null){

            }
            else{
            $data[]=[
                'etudiant'=>$info,
                'presence'=>$presence
            ];}
        }
        foreach ($etud as $id=>$presence){
            $info=$etudiantRepository->find($id);
            if ($info==null){

            }
            else{
            $send[]=[
                'id'=>$info->getId(),
                'nom'=>$info->getNom(),
                'prenom'=>$info->getPrenom(),
                'numero'=>$info->getNumero(),
                'presence'=>$presence,
            ];}
        }

        $session->set('data',$send);
        return $this->render('prof/index.html.twig',
            compact("data","an"));
    }
    #[Route('/present/{id}/{an}', name: 'app_present')]
    public function presence(int $id,int $an,SessionInterface $session,EtudiantRepository $etudiantRepository): Response
    {
        $list=$session->get('list',[]);
        if ($list[$id]==0){
            $list[$id]=1;
        }
        else{
            $list[$id]=0;
        }

        $session->set("list",$list);
        return $this->redirectToRoute('app_prof',compact("an"));
    }
}
