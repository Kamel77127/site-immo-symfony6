<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Validator\Constraints\Valid;

class RegisterFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'error_bubbling' => true,
                'label' => false,
                'attr' => [
                    'placeholder' => 'exemple@gmail.com',
                    'class' => 'email-input col-sm-12 col-md-12 col-lg-12 mx-auto my-auto',
                    'style' => 'width:100%;'
                ],
                'trim' => true,
                'error_bubbling' => true,
                'constraints' => [
                    new NotBlank(
                        ['message' => "Les champs ci-dessous doivent être remplis"]
                    ),
                  

                ],
            ])
            ->add(
                'password',
                RepeatedType::class,
                [
                    
                    'error_bubbling' => true,
                    'help' =>'le mot de passe doit contenir entre 6 et 20 caractères',
                    'type' => PasswordType::class,
                    'trim' => true,
                    'first_options' => [
                        'label' => 'Votre mot de passe',
                        'attr' => [
                            'placeholder' => '********',
                            'class' => 'col-md-12 col-lg-12'
                        ]
                    ],
                    'second_options' => [
                        'label' => 'Confirmation du mot de passe',
                        'attr' => [
                            'placeholder' => '********',
                            'class' => 'col-md-12 col-lg-12'
                        ]
                    ],
                    'constraints' => [
                        new Length(
                            [
                                'min' => 6,
                                'minMessage' =>'le mot de passe doit contenir minimum 6 caractères',
                                'max' => 20,
                                'maxMessage' =>'le mot de passe doit contenir au maximum 20 caractères',
                            ]
                        )
                    ]
                ]

            )


            ->add('submit', SubmitType::class, [
                'label' => 'créer mon compte',
                'attr' => [
                    'class' => 'search-button col-lg-4 position-absolute top-100 start-50 translate-middle mt-5'
                ],
                'validate' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
