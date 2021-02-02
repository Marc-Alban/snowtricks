<?php

namespace App\Form;

use App\Entity\Trick;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class TrickType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class)
            ->add('slug',TextType::class)
            ->add('description', TextareaType::class)
            ->add('category', CollectionType::class,[
                'entry_type'=>CategoryType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
            ])
            ->add('image',CollectionType::class,[
                'entry_type'=>ImageType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
            ])
            ->add('video',CollectionType::class,[
                'entry_type'=>VideoType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'by_reference' => false,
            ])
        ;

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Trick::class,
        ]);


    }

}
