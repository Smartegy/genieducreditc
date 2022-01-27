<?php

namespace App\Controller;

use App\Entity\Vehicule;
use App\Entity\Typemedia;
use App\Entity\Concessionnaire;
use App\Entity\GalerieVehicule;
use App\Entity\Marchand;
use App\Entity\Medias;
use App\Repository\VehiculeRepository;
use App\Repository\ConcessionnaireRepository;
use App\Repository\MarchandRepository;
use App\Repository\PartenaireRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Form\VehiculeType;
use App\Form\MediaType;
use App\Repository\AdministrateurRepository;
use App\Repository\AgentRepository;
use App\Repository\ConcessionnairemarchandRepository;
use App\Repository\GalerieVehiculeRepository;
use App\Repository\MediasRepository;
use App\Repository\TypemediaRepository;
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
     ObjectManager $om,
     GalerieVehiculeRepository $repositorygalerie
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
       
        return $this->render('vehicule/index.html.twig', [
            'vehicules' => $vehicules,
        ]);
    }




    #[Route('/add-vehicule', name: 'add_vehicule')]
    public function ajouter(Vehicule $vehicules = null,TypemediaRepository $repository,Request $request)
    {

       if(!$vehicules){

            $vehicules = new Vehicule();
       }
            $om = $this->om;
            
           

           if ($vehicules->getGalerie()->isEmpty()) {
                $image = new GalerieVehicule();
                $image->setVehicule($vehicules);  
                $vehicules->getGalerie()->add($image);
           }
            
            $form = $this->createForm(VehiculeType::class,$vehicules);
            $form -> handleRequest($request);
          
           
            if($form->isSubmitted() && $form->isValid()){
               
                $galerie =$form->getData()->getGalerie();
                
                
                foreach($galerie as $photogalerie){

                   

                    $photogaleriefile = $photogalerie->getImageFile();
                  
                    //Ajouter le nom
                   $photogalerienom= $photogaleriefile->getClientOriginalName();
                  

                    //Déplacer le fichier
                    $photogalerielien = '/media/galerie/'.$photogalerienom;
                    $photogaleriefile->move('../public/media/galerie', $photogalerienom);

                  
                    $photogalerie->setNom($photogalerienom);
                    $photogalerie->setLien($photogalerielien);

                   

                    //Ajoute le type du média
                  
                        $type = $repository->gettype('galerie');
                      
                        
                        $photogalerie->setType($type);
                    
                    
                       
                    
                } 
            
                //dd($galerie);die();
               

               


                //Récupère l'image
            $media = $form->getData()->getMedia();
             if ($media){
                //Récupère le fichier image
                $mediafile = $form->getData()->getMedia()->getImageFile();
                //Ajouter le nom
                $name = $mediafile->getClientOriginalName();
                //Déplacer le fichier
                $lien = '/media/logos/'.$name;
                $mediafile->move('../public/media/logos', $name);

                //Définit les valeurs
                $media->setNom($name);
                $media->setLien($lien);

                //Ajoute le type du média

                /* $type = 'photo';*/
                $type = $repository->gettype('photo');

                $media->setType($type);



            }
            
            
            
            $om->persist($vehicules);
           
            $om->flush();
            return $this->redirectToRoute("vehicule");
                
        
                 
             
        }

        
      
        return $this->render('vehicule/ajouter.html.twig', [
            
            'vehicules' => $vehicules,
             'form' => $form->createView()
            
        ]);   
    }     
            
    #[Route('/edit-vehicule/{id}', name: 'edit-vehicule', methods:'GET|POST')]
    
    public function edit(Vehicule $vehicules = null,VehiculeRepository $repository,Request $request): Response
    {
        if(!$vehicules){

            $vehicules = new Vehicule();
       }
            $om = $this->om;
            
        $form = $this->createForm(VehiculeType::class,$vehicules);
        $form -> handleRequest($request);
      
       
        if($form->isSubmitted() && $form->isValid()){



                                $galerie =$form->getData()->getGalerie();
                                    
                                    
                                foreach($galerie as $photogalerie){

                                

                                    $photogaleriefile = $photogalerie->getImageFile();
                                
                                    //Ajouter le nom
                                $photogalerienom= $photogaleriefile->getClientOriginalName();
                                

                                    //Déplacer le fichier
                                    $photogalerielien = '/media/galerie/'.$photogalerienom;
                                    $photogaleriefile->move('../public/media/galerie', $photogalerienom);

                                
                                    $photogalerie->setNom($photogalerienom);
                                    $photogalerie->setLien($photogalerielien);

                                

                                    //Ajoute le type du média
                                
                                        $type = $repository->gettype('galerie');
                                    
                                        
                                        $photogalerie->setType($type);
                                    
                                    
                                    
                                    
                                } 

                            $media = $form->getData()->getMedia();
                                if ($media){
                                //Récupère le fichier image
                                $mediafile = $form->getData()->getMedia()->getImageFile();
                                //Ajouter le nom
                                $name = $mediafile->getClientOriginalName();
                                //Déplacer le fichier
                                $lien = '/media/logos/'.$name;
                                $mediafile->move('../public/media/logos', $name);

                                //Définit les valeurs
                                $media->setNom($name);
                                $media->setLien($lien);

                                //Ajoute le type du média

                                /* $type = 'photo';*/
                                $type = $repository->gettype('photo');

                                $media->setType($type);
                            }
                        }                
          $om->persist($vehicules);
          
                
            
       
            $om->flush();
            return $this->redirectToRoute("vehicule");
        
        return $this->render('vehicule/modifier.html.twig', [
            'vehicules' => $vehicules,
            'form' => $form->createView()
        ]);
    }
  

}    
