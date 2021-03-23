<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\Lieu;
use App\Entity\Sortie;
use App\Entity\Ville;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SortiesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('nom')
            ->add('date_debut')
            ->add('duree')
            ->add('date_cloture')
            ->add('nb_inscriptions_max')
            ->add('description_infos')
            ->add('url_photo')
            ->add('ville', EntityType::class, [
                'mapped' => false,
                'class'=>Ville::class,
                'choice_label' => 'nom_ville',
                'multiple'=> false, 'expanded'=> false,
            ])
            ->add('lieu', EntityType::class, [
                'mapped' => false,
                'class'=>Lieu::class,
                'choice_label' => 'nom_lieu',
                'multiple'=> false,
                'expanded'=> false,
            ])

        ->add('creer', SubmitType::class, [
            'label' => 'Création'
        ])
            ->add('publier', SubmitType::class, [
                'label' => 'Publication'
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
        ]);
    }
}
