<?php

namespace App\Form;
use App\Entity\Vehicule;
use App\Entity\Carburant;
use App\Entity\Carrosserie;
use App\Entity\Category;
use App\Entity\Concessionnaire;
use App\Entity\Condition;
use App\Entity\Cylindres;
use App\Entity\Fabriquant;


use App\Entity\Modele;
use App\Entity\Moteur;
use App\Entity\Partenaire;
use App\Entity\Status;
use App\Entity\Traction;
use App\Entity\Transmission;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class VehiculeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('stock')
            ->add('vin')
            ->add('actif')
            ->add('km')
            ->add('Couleurexterieur')
            ->add('couleurinterieur')
            ->add('portes')
            ->add('Passagers')
            ->add('prixdetail')
            ->add('prixwholesale')
            ->add('Aileronarriere')
            ->add('antipatinage')
            ->add('chargeurdc')
            ->add('climatisationautomatique')
            ->add('coussingonflablepouleconducteur')
            ->add('crochetremorquagearriere')
            ->add('detecteurdepluie')
            ->add('Essuieglacesintermittentsavitessevariable')
            ->add('inclinaisonelectriquetoitouvrantcoulissant')
            ->add('miroirschauffants')
            ->add('ordinateurdebord')
            ->add('pharesantibrouillard')
            ->add('radiosatellite')
            ->add('servodirection')
            ->add('siegesarriereschauffants')
            ->add('sonardestationnementarriere')
            ->add('systemealarme')
            ->add('tacheometre')
            ->add('vitreselectriques')
            ->add('airclimatise')
            ->add('bluetooth')
            ->add('climatisation2zones')
            ->add('commandesauvolant')
            ->add('coussingonflablepourlepassager')
            ->add('degivreurarriere')
            ->add('enjoliveursderoues')
            ->add('freinsabc')
            ->add('lecteurdc')
            ->add('miroirselectriques')
            ->add('ouverturesducoffreadistance')
            ->add('pharesxenon')
            ->add('regulateurdevistesse')
            ->add('siegechauffantconducteur')
            ->add('siegesarrierestraversables')
            ->add('siegescuire')
            ->add('sunmoonroof')
            ->add('systemedenavigation')
            ->add('tapisdesolavant')
            ->add('vitresteintes')
            ->add('amfmsterio')
            ->add('cameraderecul')
            ->add('climatisationarriere')
            ->add('controledestabilite')
            ->add('cousinsgonflableslateraux')
            ->add('demarragesanscle')
            ->add('entreesanscle')
            ->add('freinsassistes')
            ->add('lecteurmp')
            ->add('miroirssignaldecourbeintegre')
            ->add('particulier')
            ->add('porteselectriques')
            ->add('serruresdesecuritepourenfant')
            ->add('siegeelectriqueconducteur')
            ->add('siegesbaquets')
            ->add('siegesmemoire')
            ->add('systemeantivol')
            ->add('systemesurveillancepressiondespneus')
            ->add('toitouvrant')
            ->add('disponiblefinance')
            ->add('financement')
            ->add('disponiblegarentie')
            ->add('garentie')
            ->add('description')
            ->add('datecreation')
            ->add('datemodification')
            ->add('marque',EntityType::class,[
                'class' => Fabriquant::class,
                'choice_label' => function ($marq) {
                 
                   return $marq->getMarque();
                },
                'expanded' => false
                
            ])
           
            ->add('modele',EntityType::class,array(
                'class' => Modele::class,
                'choice_label' => 'nom',
  
            ))
    
          
        

            ->add('category',EntityType::class,array(
                'class' => Category::class,
                'choice_label' => 'nom',
  
            ))
       
            ->add('status',EntityType::class,[
                'class' => Status::class,
                'choice_label' => function ($stat) {
               
                 
                   return $stat->getStatus();
                },
                'expanded' => false
                
            ])
         
          

            ->add('carrosserie',EntityType::class,array(
                'class' => Carrosserie::class,
                'choice_label' => 'nom',
  
            ))
       

            ->add('transmission',EntityType::class,array(
                'class' => Transmission::class,
                'choice_label' => 'nom',
  
            ))
      


            ->add('Carburant',EntityType::class,array(
                'class' => Carburant::class,
                'choice_label' => 'nom',
  
            ))

            ->add('traction',EntityType::class,array(
                'class' => Traction::class,
                'choice_label' => 'nom',
  
            ))
         
        

            ->add('cylindres',EntityType::class,array(
                'class' => Cylindres::class,
                'choice_label' => 'nom',
  
            ))


            ->add('moteur',EntityType::class,array(
                'class' => Moteur::class,
                'choice_label' => 'nom',
  
            ))

            ->add('media', MediasType::class)
        
            ->add('conditions',EntityType::class,[
                'class' => Condition::class,
                'choice_label' => function ($con) {
             
                 
                   return $con->getConditions();
                },
                'expanded' => false
                
            ])
           
            ->add('concessionnaire',EntityType::class,[
                'class' => Concessionnaire::class,
                'choice_label' => function ($cons) {
                 
                 
                   return $cons->getConcessionnaire();
                },
                'expanded' => false
                
            ])
           
            ->add('partenaire',EntityType::class,[
                'class' => Partenaire::class,
                'choice_label' => function ($par) {
                 
                 
                   return $par->getPartenaire();
                },
                'expanded' => false
                
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Vehicule::class,
        ]);
    }
}
