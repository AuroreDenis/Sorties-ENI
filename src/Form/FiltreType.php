<?php

namespace App\Form;


use App\Entity\Campus;
use App\Entity\Filtre;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FiltreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {


        $builder
            ->add('campus', EntityType::class, [
                'class' => Campus::class,
                'choice_label' => 'nom_campus',
                'multiple'=> false,
                'expanded'=> false,
            ])
            ->add('Search', TextType::class, [
                'label' => 'Le nom de la sortie contient :',
                'required'=>false
            ])
            ->add('DateDebut', DateType::class,[
                'label' => 'Entre le ',
                'format' => 'dd-MMMM-yyyy'])
            ->add('DateFin', DateType::class,[
                'label' => ' et le ',
                'format' => 'dd-MMMM-yyyy'])

            ->add('orga',CheckboxType::class, [
        'label'    => 'Je suis organisatrice de cette sortie',
        'required' => false,
                ])
            ->add('inscrit',CheckboxType::class, [
                'label'    => 'Je suis inscrite à cette sortie',
                'required' => false,
            ])
            ->add('pasInscrit',CheckboxType::class, [
        'label'    => 'Je ne suis pas inscrite à cette sortie',
        'required' => false,
    ])
            ->add('close',CheckboxType::class, [
        'label'    => 'Sorties passées',
        'required' => false,
    ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Filtre::class,
        ]);
    }
}
