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
                'allow_add'=>true,
                'allow_delete'=>true,
            ])
            ->add('image',CollectionType::class,[
                'entry_type'=>ImageType::class,
                'allow_add'=>true,
                'allow_delete'=>true,
            ])
            ->add('video',CollectionType::class,[
                'entry_type'=>VideoType::class,
                'allow_add'=>true,
                'allow_delete'=>true,
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
