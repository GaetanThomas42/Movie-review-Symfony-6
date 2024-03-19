<?php

namespace App\Form;

use App\Entity\Genre;
use App\Entity\Media;
use App\Entity\Type;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class MediaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class,
                [
                    'empty_data' => '',
                    'label' => 'Titre',
                ])
            ->add('description', null,
                [
                    'empty_data' => '',
                ])

            ->add('imageFile', FileType::class, [
                'label' => 'Image de couverture',
                // unmapped means that this field is not associated to any entity property
                'mapped' => false,
                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => true,
                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '4096k',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpeg',
                            'image/webp',
                            'image/gif',
                        ],
                        'mimeTypesMessage' => 'Votre image doit être au format : png, jpg, gif ou webp',
                    ])
                ],
            ])
            ->add('releaseDate', DateType::class,
                [
                    'label' => 'Date de sortie',
                    'widget' => 'single_text',
                ])
            ->add('duration', TimeType::class,
                [
                    'label' => 'Durée',
                    'widget' => 'single_text',
                    'with_seconds' => true
                ])
            ->add('genres', EntityType::class,
                [
                    'class' => Genre::class,
                    'multiple' => true,
                    'expanded' => true
                ])
            ->add('type', EntityType::class,
                [
                    'class' => Type::class,
                    'choice_label' => 'name',

                ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Media::class,
        ]);
    }
}
