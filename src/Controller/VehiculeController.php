<?php

namespace App\Controller;

use App\Entity\Vehicule;
use App\Entity\Concessionnaire;
use App\Entity\Marchand;
use App\Repository\VehiculeRepository;
use App\Repository\ConcessionnaireRepository;
use App\Repository\MarchandRepository;
use App\Repository\PartenaireRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Form\VehiculeType;
use App\Repository\AdministrateurRepository;
use App\Repository\AgentRepository;
use App\Repository\ConcessionnairemarchandRepository;
use App\Repository\MediasRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VehiculeController extends AbstractController
{
    public function __construct(MediasRepository $MR,
     PartenaireRepository $partenaireRepository, 
     AgentRepository $agentRepository,
     ConcessionnairemarchandRepository $concessionnairemarchandRepository,
     AdministrateurRepository $administrateurRepository,
     ObjectManager $om
     )
    {
        $this->MR = $MR;
        $this->om = $om;
        //ici on instancie le repo
        $this->partenaireRepository = $partenaireRepository;
        $this->AgentRepository = $agentRepository;
        $this->ConcessionnairemarchandRepository = $concessionnairemarchandRepository;
        $this->AdministrateurRepository = $administrateurRepository;
        
        
    }


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
    public function ajouter(Vehicule $vehicules = null,ConcessionnaireRepository $repository,MarchandRepository $repositorym,ObjectManager $objectManager,PartenaireRepository $repositoryp,Request $request)
    {

        //$concessionnaires = $repository -> findAll();
        //$marchands = $repositorym -> findAll();
        //$partenaires = $repository -> findAll();
        
        
        

       if(!$vehicules){

            $vehicules = new Vehicule();

         /*    //Ajouter les partenaires au select companies
            $companies=[];
            $partenairesArray = [];
            $partenaires = $this->partenaireRepository->findAll();
         
            foreach($partenaires as $partenaire){
                $partenairesRow = array(
                    'id' => $partenaire->getUtilisateur()->getID(),
                    'nom' =>$partenaire->getUtilisateur()->getNom()
            );
            
            array_push($partenairesArray, $partenairesRow);
            }

            

            $partenairesObject = (object)$partenairesArray;*/
            //var_dump($partenairesObject); die();
            

         //  array_push($companies, $partenaire->getUtilisateur()->getNom());

           /* //Ajouter les concessionnaires marchands au select companies
            $concessionnairesmarchands = $this->ConcessionnairemarchandRepository->findAll();
            foreach($concessionnairesmarchands as $concessionnairesmarchand){
            array_push($companies, $concessionnairesmarchand->getUtilisateur()->getNom());
            }

            //Ajouter les vendeurs au select companies
            $vendeurs = $this->AgentRepository->findVendeursforVehicules();
            foreach($vendeurs as $vendeur){
        
            array_push($companies, $vendeur->getUtilisateur()->getNom());
            }


            //Ajouter les administrateurs au select companies
            $administrateurs = $this->AdministrateurRepository->findAll();
            foreach($administrateurs as $administrateur){
            array_push($companies, $administrateur->getUtilisateur()->getNom());
            }
            */

            $form = $this->createForm(VehiculeType::class,$vehicules);
            $form -> handleRequest($request);
            
            //var_dump( $form->get('companies')->getData());
         //  }
         
         
            
            if($form->isSubmitted() && $form->isValid()){

            // Lier company au véhicule
        //    $selectedcompany = $request->get('companies');

    // $vehicule->setConcessionnaire($);
            





            $modif = $vehicules->getId() !== null;
            
            $objectManager->persist($vehicules);
            $objectManager->flush();
            $this->addFlash("success", ($modif) ? "La modification a été effectuée" : "L'ajout a été effectuée");
            return $this->redirectToRoute("vehicule");
                
            
                 
             }
        }


      
        return $this->render('vehicule/ajouter.html.twig', [
            
            'vehicules' => $vehicules,
          //'companies' => $partenairesObject,
           
            'form' => $form->createView()
            
        ]);   
    }     
            
   
  
 //   $marchands = $repository -> findAll(); 
  //  $partenaires = $repository -> findAll();

   // $form->get('concessionnairemarchand')->get('vendeurs')->setData($vdrs);

}    
