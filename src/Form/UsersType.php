<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Validator\Constraints as Assert;

class UsersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('name', TextType::class, [
                'attr'=>[
                    'minlength'=>'2',
                    'maxlength'=>'60',
                    'placeholder'=>'Entrez un nom',
                ],
                'label'=> 'Nom',
                'constraints'=>[
                    new Assert\NotBlank(),
                    new Assert\Length(['min'=> 2, 'max'=> 60])
                ]
                ])
            ->add('lastname', TextType::class, [
                'attr'=>[
                    'minlength'=>'2',
                    'maxlength'=>'60',
                    'placeholder'=>'Entrez un Prenom',
                ],
                'label'=> 'Prenom',
                'constraints'=>[
                    new Assert\NotBlank(),
                    new Assert\Length(['min'=> 2, 'max'=> 60])
                ]
                ])
            ->add('birth', DateType::class, [
                'label'=>'Naissance',
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type'=> PasswordType::class,
                'first_options'=> [
                    'label'=>'Mot de passe',
                    'attr'=>[
                        'minlength'=>'2',
                        'maxlength'=>'60',
                        'placeholder'=>'Entrez un mot de passe',],
                ],
                'second_options'=>[
                    'label'=>'Confirmation du mot de passe',
                    'attr'=>[
                        'minlength'=>'2',
                        'maxlength'=>'60',
                        'placeholder'=>'Confirmer le mot de passe'],
                ],
                'invalid_message'=> 'Les mots de passe ne correspondent pas.'
                
            ])
            ->add('email', EmailType::class, [
                'attr'=>[
                    'minlength'=>'2',
                    'maxlength'=>'180',
                    'placeholder'=>'Entrez une address email'],
                'label'=>'Adresse email',
                'constraints'=>[
                    new Assert\NotBlank(),
                    new Assert\Email(),
                    new Assert\Length(['min'=> 2, 'max'=> 180])
                ]
            ])
            ->add('diet', CollectionType::class, [
                'attr'=> [
                    'class'=>'form-control'],
                'label'=>'regime',
                'label_attr'=>[
                    'class'=>'form-label'],
                    'entry_type'=> TextType::class,
                    'by_reference'=>false,
                    "allow_add"=>true,
                    "allow_delete"=>true
            ])
            ->add('allergen', CollectionType::class, [
                'attr'=> [
                    'class'=>'form-control'],
                'label'=>'allergies',
                'label_attr'=>[
                    'class'=>'form-label'],
                    'entry_type'=> TextType::class,
                    'by_reference'=>false,
                    "allow_add"=>true,
                    "allow_delete"=>true,
            ])

            ->add('submit', SubmitType::class,[
                'attr'=>[
                    'class'=> 'btn-submit',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
