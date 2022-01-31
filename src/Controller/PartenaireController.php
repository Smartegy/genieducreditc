<?php
namespace App\Controller;
use App\Entity\Partenaire;
use App\Entity\Utilisateur;
use App\Form\PartenaireType;
use App\Repository\AgentRepository;
use App\Repository\PartenaireRepository;
use Doctrine\Persistence\ObjectManager;
use App\Form\SecurityPartenaireType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
class PartenaireController extends AbstractController
{
    public function __construct(ObjectManager $om,
     PartenaireRepository $PartenaireRepository,
     AgentRepository $AgentRepository
    )
   {
      
       $this->om = $om;
       $this->PartenaireRepository = $PartenaireRepository;
       $this->AgentRepository = $AgentRepository;
    
   }
    #[Route('/partenaire', name: 'partenaire')]
    public function index(PartenaireRepository $repository , AgentRepository $AgentRepository ): Response
    {
        $agents = $AgentRepository->findAll();
        $partenaires = $repository -> findAll();
        return $this->render('partenaire/index.html.twig', [
           
            'partenaires' => $partenaires ,
            'agent' => $agents
        ]);
    }
    #[Route('/partenaire/creation', name: 'creation_partenaire')]
    public function ajout_partenaire(Partenaire $partenaire = null, ObjectManager $objectManager, Request $request)
    {
     
        if(!$partenaire){
            $partenaire = new Partenaire();
            
        }
        $om=$this->om;
    
        
        
       
        $form = $this->createForm(PartenaireType::class, $partenaire);
        
        //On recupere le partenaire
        $partenaire = $form->getData();
        
        if($partenaire != null){
        //On recupere les vendeurs liés au Partenaire
        $prtnrs = $this->AgentRepository->findVendeurbyPartenaire($partenaire->getId());
       
        //On ajoute les valeurs selected dans la select list Vendeurs
        $form->get('vendeurs')->setData($prtnrs);
        
        }
        $form -> handleRequest($request);
       // $vendeurs = $form->getData('vendeurs');
        //($vendeurs);
       
       // dd($vendeurs);
        if($form->isSubmitted() && $form->isValid()){
            $vendeurs =$form->get('vendeurs')->getData();
            //Ajoute la liste des vendeurs (non mapped)
             //Ajoute la liste des vendeurs (unmapped)
             foreach ($vendeurs as $vendeur){
                $partenaire->addAgent($vendeur);
            }
            $vendeurvalue = $form->get('vendeurs')->getData();
            if($vendeurvalue != null){
                $ven = $this->AgentRepository->fillVendeur($vendeurvalue->getId());
                $form->get('vendeurs')->setData($ven);
            }
            
            
           
            $objectManager->persist($partenaire);
            $objectManager->flush();
            return $this->redirectToRoute("partenaire");
        }
        
        return $this->render('partenaire/modificationetajoutPartenaire.html.twig', [
            'partenaires' => $partenaire,
            'form' => $form->createView(),
            'isModification' => $partenaire->getId() !== null,
            
        ]);
    }

    #[Route('/partenaire/{id}', name: 'modification_partenaire', methods:'GET|POST')]
    public function modification_partenaire(Partenaire $partenaire = null, ObjectManager $objectManager, Request $request)
    {

        if(!$partenaire){
            $partenaire = new Partenaire();

        }
        $om=$this->om;




        $form = $this->createForm(PartenaireType::class, $partenaire);

        //On recupere le partenaire
        $partenaire = $form->getData();

        if($partenaire != null){
            //On recupere les vendeurs liés au Partenaire
            $prtnrs = $this->AgentRepository->findVendeurbyPartenaire($partenaire->getId());

            //On ajoute les valeurs selected dans la select list Vendeurs
            $form->get('vendeurs')->setData($prtnrs);

        }
        $form -> handleRequest($request);
        // $vendeurs = $form->getData('vendeurs');
        //($vendeurs);

        // dd($vendeurs);
        if($form->isSubmitted() && $form->isValid()){
            $vendeurs =$form->get('vendeurs')->getData();
            //Ajoute la liste des vendeurs (non mapped)
            //Ajoute la liste des vendeurs (unmapped)
            foreach ($vendeurs as $vendeur){
                $partenaire->addAgent($vendeur);
            }
            $vendeurvalue = $form->get('vendeurs')->getData();
            if($vendeurvalue != null){
                $ven = $this->AgentRepository->fillVendeur($vendeurvalue->getId());
                $form->get('vendeurs')->setData($ven);
            }



            $objectManager->persist($partenaire);
            $objectManager->flush();
            return $this->redirectToRoute("partenaire");
        }

        return $this->render('partenaire/modificationPartenaire.html.twig', [
            'partenaires' => $partenaire,
            'form' => $form->createView(),
            'isModification' => $partenaire->getId() !== null,

        ]);
    }

    #[Route('/consulter-partenaire/{id}', name: 'consultation_partenaire', methods:'GET|POST')]
 public function consultation(Partenaire $partenaire): Response
 {
     
    
    $partenaire = $this->PartenaireRepository ->findOneById($partenaire->getId());
    $agents = $this->AgentRepository-> findAgentbyPartnaire($partenaire->getId()); 
   // dd($agents);  
    $vendeurs = $this->AgentRepository-> findVendeurbyPartenaire($partenaire->getId());                  
     return $this->render('partenaire/consultation.html.twig', [
         'partenaire' => $partenaire,
         'vendeurs' => $vendeurs,
         'agents' => $agents
      
     ]);
 }
    
 #[Route('/security-partenaires/{id}', name: 'security_partenaire', methods:'GET|POST')]
 public function secure(Partenaire $partenaire = null,UserPasswordHasherInterface $userPasswordHasher, ObjectManager $objectManager, Request $request)
 {
 
             if(!$partenaire){
                 $partenaire = new Partenaire();
                 
                             }
             
             $form = $this->createForm(SecurityPartenaireType::class,$partenaire)->remove('password');
             $form -> handleRequest($request);
             
             $user= new Utilisateur();
         
         
         //dd($form->getData());
         
         if($form->isSubmitted() && $form->isValid()){
            
             
                             // encode the plain password
                             $partenaire->getUtilisateur()->setPassword(
                                 $userPasswordHasher->hashPassword(
                                         $user,
                                         $form->get('utilisateur')->get('password')->getData()
                                     )
                                 );
                             
                         
                         
                         $objectManager->persist($partenaire);
                         $objectManager->flush();
                        
                         return $this->redirectToRoute("partenaire");
                     
             
             }
             
            
             
         return $this->render('partenaire/Security.html.twig', [
             'agent' => $partenaire,
             'form' => $form->createView()
             
         
         ]);
 
 }
 #[Route('/delete-partenaire/{id}', name: 'delete_partenaire', methods:'delete')]
 public function suppression(Partenaire $partenaire, Request $request,ObjectManager $objectManager){
     if($this->isCsrfTokenValid("SUP". $partenaire->getId(),$request->get('_token'))){
         $objectManager->remove($partenaire);
         $objectManager->flush();
         return $this->redirectToRoute("partenaire");
     }
 }
}