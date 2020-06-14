<?php

namespace App\Form;

use App\Entity\Annonce;
use App\Entity\Categorie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CurrencyType;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('annonceTitle', TextType::class)

            ->add('annonceDescription', CKEditorType::class)
            ->add('budget', CurrencyType::class)
            ->add('adress', [
                'label_format' => 'form.address.%name%',
            ])
            ->add('postalCode')
            ->add('image file', VichImageType::class, [
                'label' => 'Image mis en avant'
            ])
            ->add('city', TextType::class)
            ->add('categorys', EntityType::class, [ "class"=> Categorie::class,
            'multiple' => true,
            'expanded' => true
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
