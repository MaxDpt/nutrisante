<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Validator\Constraints as Assert;

class ContactsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'attr'=>[
                    'minlength'=>'2',
                    'maxlength'=>'60',
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
                ],
                'label'=> 'Prenom',
                'constraints'=>[
                    new Assert\NotBlank(),
                    new Assert\Length(['min'=> 2, 'max'=> 60])
                ]
                ])
            ->add('email', EmailType::class, [
                'attr'=>[
                    'minlength'=>'2',
                    'maxlength'=>'180',],
                'label'=>'Adresse email',
                'constraints'=>[
                    new Assert\NotBlank(),
                    new Assert\Email(),
                    new Assert\Length(['min'=> 2, 'max'=> 180])
                ]
            ])
            ->add('subject', TextType::class, [
                'attr'=>[
                    'minlength'=>'2',
                    'maxlength'=>'60',
                ],
                'label'=> 'sujet',
                'constraints'=>[
                    new Assert\NotBlank(),
                    new Assert\Length(['min'=> 2, 'max'=> 60])
                ]
                ])
            ->add('text', TextareaType::class, [
                'constraints'=>[
                    new Assert\NotBlank()
                ]
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
            'data_class' => Contact::class,
        ]);
    }
}
