<?php
namespace App\Form;
use App\Entity\Partenaire;
use App\Entity\Agent;
use App\Form\UtilisateurType;
use App\Repository\AgentRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
class PartenaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('description', TextareaType::class)
            ->add('actif')
            ->add('utilisateur', UtilisateurType::class)
            ->add('agents', EntityType::class,array(
                'class' => Agent::class,
                'choice_label' => 'utilisateur.nom', 
                'query_builder' => function(AgentRepository $repo)
                {
                    $agents = $repo->fillAgents();
                    return $agents;
                    },
                    
                    'expanded' => false,
                    'multiple' => true
                  
                ))
                ->add('vendeurs', EntityType::class,array(
                    'class' => Agent::class,
                    'choice_label' => 'utilisateur.nom', 
                    'query_builder' => function(AgentRepository $repo)
                    {
                        $vendeurs = $repo->fillVendeurs();
                        return $vendeurs;
                        },
                        
                        'expanded' => false,
                        'multiple' => true,
                        'mapped' => false
                    ))
        ;
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Partenaire::class,
        ]);
    }
}


















