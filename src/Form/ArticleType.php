<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Annonce;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('annonceTitle')

            ->add('annonceDescription')
            ->add('budget')
            ->add('adress')
            ->add('postalCode')
            ->add('annoncePicture')
            ->add('city')
            ->add('categorys', EntityType::class, [ "class"=> Categorie::class,
            'choice_label' => 'nomCategorie'
            ])
            //->add('fkUserAdmin', EntityType::class, [ "class"=> UserAdmin::class])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Annonce::class,
        ]);
    }
}
