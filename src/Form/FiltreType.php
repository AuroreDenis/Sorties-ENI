<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\FormBuilderInterface;

class FiltreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
         /*  ->add('campus',ChoiceType::class, [
                'Campus'  => [
                    'NANTES' => 'NANTES',
                    'RENNES' => 'RENNES'
                ]
            ])
           */ ->add('search', SearchType::class, [
                'label' => 'Le nom doit contenir :'
            ])
        ;

    }

}
