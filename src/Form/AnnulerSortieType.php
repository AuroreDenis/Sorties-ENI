<?php

namespace App\Form;

use App\Entity\Sortie;
use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnnulerSortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id',IntegerType::class,['disabled' => true])//,NumberType::class,['readonly'=>true,])
            //->add('nom')
            //->add('date_debut')
            //->add('duree')
            //->add('date_cloture')
            //->add('nb_inscriptions_max')
            ->add('description_infos')
            //->add('url_photo')
            //->add('etat')
            //->add('organisateur')
            //->add('participants')
            //->add('lieu')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
        ]);
    }
}
