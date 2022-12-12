<?php

namespace App\Form;

use App\Data\SearchData;
use App\Entity\Lieux;
use App\Entity\Region;
use App\Entity\Type;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('region', EntityType::class, [
                'class' => Region::class,
                'choice_label' => 'name',
                'required' => false,
                'attr' => [
                    'class' => 'col-sm-12 col-xl-6 col-xxl-6 ',
                    'id' => 'region',
                    'placeholder' => 'choisir les villes'
                ],
            ])

            ->add('ville', EntityType::class, [
                'class' => Lieux::class,
                'choice_label' => 'ville',
                'required' => false,
                'attr' => [
                    'class' => 'col-sm-12 col-xl-12 ',
                    'id' => 'ville',
                    'placeholder' => 'choisir les villes'
                ],
                'multiple' => true,
            ])



            ->add('type', EntityType::class, [
                'class' => Type::class,
                'label' => false,
                'required' => false,
                'choice_label' => 'title',
                'attr' => [
                    'placeholder' => 'type de bien',
                    'class' => 'col-sm-6 col-xl-12 col-xxl-12',                 
                    'id' => 'type',
                ],
                'multiple' => true,
            ])

            ->add('piece', IntegerType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'nombre de pièces',
                    'class' => 'col-xl-12 col-sm-12 p-1',
                    'style' => 'height:100%;'
                ],
            ])

            ->add(
                'surface',
                IntegerType::class,

                [
                    'required' => false,
                    'label' => false,
                    'attr' => [
                        'placeholder' => 'surface minimum',
                        'class' => 'col-sm-12 col-xl-12 p-1',
                        'style' => 'height:45px'
                    ],
                ]
            )

            ->add(
                'price',

                IntegerType::class,
                [
                    'required' => false,
                    'label' => false,
                    'attr' => [
                        'placeholder' => 'prix maximum',
                        'class' => 'col-sm-12 col-xl-12 p-1',
                        'style' => 'height:100%',
                    ],
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void

    {
        $resolver->setDefaults([
            'data_class' => SearchData::class,
            'method' => 'GET',
            'csrf_protection' => false,
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
