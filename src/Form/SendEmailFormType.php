<?php

namespace App\Form;

use App\Data\SendEmail;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SendEmailFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class ,[
                'label' => false,
                'attr' => [
                    'class' => 'col-md-6 col-lg-8'
                ]
            ]  )
            ->add('prenom',TextType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'col-md-6 col-lg-6'
                ]
            ]  )
            ->add('sexe',ChoiceType::class, [
                'label' => false,
                'choices' => [
                    'homme' => 'homme',
                    'femme' => 'femme'
                ],
                'attr' => [
                    'class' => 'col-sm-6 col-md-6 col-lg-6'
                ]
            ] )
            ->add('email',EmailType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'col-sm-12 col-md-12 col-lg-12 mx-auto email-input'
                ]
            ] )
            ->add('tel',IntegerType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'col-sm-6 col-md-6 col-lg-6'
                ]
            ] )

            ->add('message',TextareaType::class,[
                'label' => false,
                'required' => false,
                'attr' => [
                    'class' => 'col-md-12 col-sm-12 col-lg-12 mx-auto'
                ]
                
            ] )
            ->add('submit', SubmitType::class, [
                'label' => 'envoyer',
                'attr' => [
                    'class' => 'search-button mx-auto mb-3 col-sm-12'
                ]
            ] )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SendEmail::class
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
