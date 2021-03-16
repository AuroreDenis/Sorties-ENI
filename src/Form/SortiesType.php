<?php

namespace App\Form;

use App\Entity\Etats;
use App\Entity\Sorties;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SortiesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $ferme = new Etats();
        $ferme->setLibelle('close');

        $ouvert = new Etats();
        $ouvert->setLibelle('ouvert');

        $archive = new Etats();
        $archive->setLibelle('qrchivée');

        $builder
            ->add('nom')
            ->add('date_debut')
            ->add('duree')
            ->add('date_cloture')
            ->add('nb_inscriptions_max')
            ->add('description_infos')
            ->add('etat_sortie')
            ->add('url_photo')
            ->add('etat', ChoiceType::class, [
                'choices'  => [
                    'ouvert' => $ouvert ,
                    'fermé' => $ferme,
                    'archivée' => $archive
                    ]
          ])
       //    ->add('organisateur')
          /*  ->add('lieux')
       */ ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sorties::class,
        ]);
    }
}
