<?php

namespace App\Form;

use App\Entity\Commentary;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Validator\Constraints as Assert;

class CommentaryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('name', TextType::class, [
                'attr'=>[
                    'class'=>'name',
                    'minlength'=>'2',
                    'maxlength'=>'60',
                ],
                'label'=> 'Nom',
                'constraints'=>[
                    new Assert\NotBlank(),
                    new Assert\Length(['min'=> 2, 'max'=> 60])
                ]
                ])
            ->add('text', TextareaType::class, [
                'attr'=>[
                    'class'=>'text'
                ],
                'constraints'=>[
                    new Assert\NotBlank()
                ]
                ])
            ->add('score', HiddenType::class, [
                'attr'=>[
                    'class'=>'score',
                    'value'=> 0
                ],
                'constraints'=>[
                    new Assert\Positive()
                ]
            ])
            ->add('submit', SubmitType::class,[
                'attr'=>[
                    'class'=> 'submit',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Commentary::class,
        ]);
    }
}
