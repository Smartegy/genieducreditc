<?php

namespace App\Controller;

use App\Entity\Vehicule;
use App\Repository\VehiculeRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Form\VehiculeType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VehiculeController extends AbstractController
{
    #[Route('/vehicule', name: 'vehicule')]
    public function index(VehiculeRepository $repository): Response
    {
        $vehicules = $repository -> findAll();
        dd($vehicules);
        return $this->render('vehicule/index.html.twig', [
            'vehicules' => $vehicules,
        ]);
    }




    #[Route('/add-vehicule', name: 'add_vehicule')]
    public function ajouter(Vehicule $vehicules = null,ObjectManager $objectManager,Request $request)
    {
        if(!$vehicules){

            $vehicules = new Vehicule();
            $form = $this->createForm(VehiculeType::class,$vehicules);
             $form -> handleRequest($request);



             if($form->isSubmitted() && $form->isValid()){
            $modif = $vehicules->getId() !== null;
            
            $objectManager->persist($vehicules);
            $objectManager->flush();
            $this->addFlash("success", ($modif) ? "La modification a été effectuée" : "L'ajout a été effectuée");
            return $this->redirectToRoute("vehicule");
                 
             }
        }
       
        return $this->render('vehicule/ajouter.html.twig', [
            
            'vehicules' => $vehicules,
            'form' => $form->createView()
            
        ]);   
    }     
            
    

}    
