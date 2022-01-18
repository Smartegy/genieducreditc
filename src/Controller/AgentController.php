<?php
namespace App\Controller;
use App\Entity\Agent;
use App\Entity\Utilisateur;
use App\Repository\AgentRepository;
use App\Form\AgentType;
use App\Form\EditAgentType;
use App\Form\SecAgentType;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
class AgentController extends AbstractController
{
    #[Route('/agent', name: 'agent')]
    public function index(AgentRepository $repository): Response
    {
        $agentss = $repository -> findAll();
        return $this->render('agent/index.html.twig', [
            'agent' => $agentss,
        ]);
    }
    #[Route('/agent/add-agent', name: 'add_agent')]
  public function ajout_modification(Agent $agent = null, UserPasswordHasherInterface $userPasswordHasher, ObjectManager $objectManager, Request $request)
  {
      
      if(!$agent){
          $agent = new Agent();
          
      }
 
      
      $form = $this->createForm(AgentType::class,$agent);
      $form -> handleRequest($request);
      
      $user= new Utilisateur();
  
     
    
      //dd($form->getData());
    
    if($form->isSubmitted() && $form->isValid()){
       // if($form->isSubmitted()){
       
                        
                         // encode the plain password
                         $agent->getUtilisateur()->setPassword(
                            $userPasswordHasher->hashPassword(
                                    $user,
                                    $form->get('utilisateur')->get('password')->getData()
                                )
                            );
                        
                    $modif = $agent->getId() !== null;
                    
                    $objectManager->persist($agent);
                    $objectManager->flush();
                    $this->addFlash("success", ($modif) ? "La modification a été effectuée" : "L'ajout a été effectuée");
                    return $this->redirectToRoute("agent");
               
               
      
      }
      
      
      return $this->render('agent/modificationetajoutAgent.html.twig', [
          'agent' => $agent,
          'form' => $form->createView(),
          'isModification' => $agent->getId() !== null
      ]);
    }
    #[Route('/conslt-agent/{id}', name: 'consultation_agent', methods:'GET|POST')]
 public function consultation(AgentRepository $repository,Agent $agent): Response
 {
     
     
     $agent = $repository ->findOneById ($agent->getId());
      
                         
     return $this->render('agent/consultation.html.twig', [
         'agent' => $agent
      
     ]);
 }
 #[Route('/secure-agent/{id}', name: 'secure_agent', methods:'GET|POST')]
 public function secure(Agent $agent = null,UserPasswordHasherInterface $userPasswordHasher, ObjectManager $objectManager, Request $request)
 {
 
             if(!$agent){
                 $agent = new Agent();
                 
                             }
             
             $form = $this->createForm(SecAgentType::class,$agent)->remove('password');
             $form -> handleRequest($request);
             
             $user= new Utilisateur();
         
         
         //dd($form->getData());
         
         if($form->isSubmitted() && $form->isValid()){
            
             
                             // encode the plain password
                             $agent->getUtilisateur()->setPassword(
                                 $userPasswordHasher->hashPassword(
                                         $user,
                                         $form->get('utilisateur')->get('password')->getData()
                                     )
                                 );
                             
                         
                         
                         $objectManager->persist($agent);
                         $objectManager->flush();
                        
                         return $this->redirectToRoute("agent");
                     
             
             }
             
             //dd($form->get('utilisateur')->get('plainPassword')->getData());
         // dd((string) $form->getErrors(true, false));die;
        // dd($form->getData($form->get('utilisateur')->get('password')->getData()));
             
         return $this->render('agent/Security.html.twig', [
             'agent' => $agent,
             'form' => $form->createView()
             
         
         ]);
 
 }
 #[Route('/modify-agent/{id}', name: 'modify_agent', methods:'GET|POST')]
 public function modification(Agent $agent = null, ObjectManager $objectManager,UserPasswordHasherInterface $userPasswordHasher, Request $request)
{
             if(!$agent)
             {
                 $agent = new Agent();
                 
             }
         
         $form = $this->createForm(EditAgentType::class,$agent)->remove("password");
         $form -> handleRequest($request);
         
         $user= new Utilisateur();
     //$user->getPassword( $form->get('utilisateur')->get('plainPassword')->getData());
     
     
     
     if($form->isSubmitted() && $form->isValid())
     {
         
                        
                              
                     $modif = $agent->getId() !== null;
                     
                     $objectManager->persist($agent);
                     $objectManager->flush();
                     $this->addFlash("success", ($modif) ? "La modification a été effectuée" : "L'ajout a été effectuée");
                     return $this->redirectToRoute("agent");
                 
                 
         
         
     }
    
     return $this->render('agent/modification.html.twig', [
         'agent' => $agent,
         'form' => $form->createView(),
         'isModification' => $agent->getId() !== null
     ]);
 }
 #[Route('/delete-agent/{id}', name: 'delete_agent', methods:'delete')]
 public function suppression(Agent $agent, Request $request,ObjectManager $objectManager){
     if($this->isCsrfTokenValid("SUP". $agent->getId(),$request->get('_token'))){
         $objectManager->remove($agent);
         $objectManager->flush();
         return $this->redirectToRoute("agent");
     }
 }
}
