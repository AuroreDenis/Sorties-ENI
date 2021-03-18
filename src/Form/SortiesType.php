<?php

namespace App\Form;


use App\Entity\Lieu;
use App\Entity\Sortie;
use App\Entity\Ville;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SortiesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $ville1 =new Ville();
        $ville1->setCodePostal('11111');
        $ville1->setNomVille('ville1');
        $lieu1 = new Lieu();
        $lieu1->setNomLieu('Lieu1');
        $lieu1->setLatitude(1.1);
        $lieu1->setLongitude(1.1);
        $lieu1->setRue('rue1');
        $lieu1->setVille($ville1);

        $builder
            ->add('nom')
            ->add('date_debut')
            ->add('duree')
            ->add('date_cloture')
            ->add('nb_inscriptions_max')
            ->add('description_infos')
            ->add('url_photo')
            ->add('ville', ChoiceType::class, [
                'label' => 'Ville',
                'mapped' => false,
                'choices'  => [
        'Nantes' => 'Nantes',
        'Rennes' => 'Rennes',
    ],
            ])
            ->add('lieu', ChoiceType::class,[
                'choices'  => [
                    'Lieu1' => $lieu1
                ],

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
