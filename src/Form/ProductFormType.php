<?php

namespace App\Form;

use App\Entity\Departement;
use App\Entity\Lieux;
use App\Entity\Product;
use App\Entity\Region;
use App\Entity\Type;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Appartement 3 pièces',
                    'class' => 'email-input col-lg-12 mx-auto my-auto'
                ],
            ])


            ->add('description', TextareaType::class, [
                'label' => false,
                'attr' => [
                
                    'class' => 'email-input col-md-12 col-lg-12 mx-auto my-auto'
                ],
            ])



            ->add(
                'surface',
                IntegerType::class,
                [
                    'label' => false,
                    'attr' => [
                       
                        'class' => 'email-input col-lg-6 mx-auto my-auto'
                    ],
                ]
            )



            ->add(
                'price',
                IntegerType::class,
                [
                    'label' => false,
                    'attr' => [
                       
                        'class' => 'email-input col-lg-6 mx-auto my-auto'
                    ],
                ]
            )


            ->add('meuble', ChoiceType::class, [
                'label' => false,
                'choices' => [
                    'oui' => 'oui',
                    'non' => 'non',

                ],
                'attr' => [
                       
                    'class' => 'email-input col-lg-12 mx-auto my-auto'
                ],

            ])


            ->add('electricite', ChoiceType::class, [
                'label' => false,
                'choices' => [
                    'A' => 'A',
                    'B' => 'B',
                    'C' => 'C',
                    'D' => 'D',
                    'E' => 'E',
                    'F' => 'F',
                    'G' => 'G',
                ],
                'attr' => [
                       
                    'class' => 'email-input col-lg-12 mx-auto my-auto'
                ],

            ])

            ->add('gaz', ChoiceType::class, [
                'label' => false,
                'choices' => [
                    'A' => 'A',
                    'B' => 'B',
                    'C' => 'C',
                    'D' => 'D',
                    'E' => 'E',
                    'F' => 'F',
                    'G' => 'G',
                ],
                'attr' => [
                       
                    'class' => 'email-input col-lg-12 mx-auto my-auto'
                ],

            ])

            ->add('elecOuGaz', ChoiceType::class, [
                'label' => false,
                'choices' => [
                    'gaz' => 'gaz',
                    'electricité' => 'electricité',

                ],
                'attr' => [
                       
                    'class' => 'email-input col-lg-12 mx-auto my-auto'
                ],

            ])


            ->add('piece', IntegerType::class, [
                'label' => false,
                'attr' => [
                       
                    'class' => 'email-input col-lg-7 mx-auto my-auto'
                ],
              
            ])


            ->add('type', EntityType::class, [
                'class' => Type::class,
                'choice_label' => 'title',
                'label' => false,
                'expanded' => true,
                'attr' => [
                       
                    'class' => 'email-input d-flex gap-2 col-lg-2 my-auto'
                ],

            ])



            ->add('ville', EntityType::class, [
                'class' => Lieux::class,

                'label' => false,
                'choice_label' => 'ville',


                'attr' => [
                    'class' => 'select2 col-sm-12 col-lg-12'
                ],

            ])

            ->add('departement', EntityType::class, [
                'class' => Departement::class,
                'label' => false,
                'choice_label' => 'name',
                'attr' => [
                    'class' => 'select2 col-lg-12'
                ],

            ])


            ->add('region', EntityType::class, [
                'class' => Region::class,
                'label' => false,
                'choice_label' => 'name',
                'attr' => [
                    'class' => 'select2 col-lg-12'
                ],

            ])

            ->add('image', CollectionType::class, [
                'entry_type' => ImageFormType::class,
                'prototype' => true,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'data_class' => null,

                'mapped' => false,




            ])

            ->add('submit', SubmitType::class, [
                'label' => 'envoyer',
                'attr' => [
                    'class' => 'search-button mb-5 col-lg-12'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
            'allow_file_upload' => true
        ]);
    }
}
