<?php

namespace App\Form;

use App\Entity\Recipes;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Validator\Constraints as Assert;

class RecipesType extends AbstractType
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
            ->add('prepaTime', TimeType::class, [
                'label'=>'temp de préparation',
            ])
            ->add('cookingTime', TimeType::class, [
                'label'=>'temp de cuisson',
            ])
            ->add('restTime', TimeType::class, [
                'label'=>'temp de repos',
            ])
            ->add('diet', CollectionType::class, [
                'attr'=> [
                    'class'=>'form-control'],
                'label'=>'regime',
                'label_attr'=>[
                    'class'=>'form-label']
            ])
            ->add('allergen', CollectionType::class, [
                'attr'=> [
                    'class'=>'form-control'],
                'label'=>'allergies',
                'label_attr'=>[
                    'class'=>'form-label']
            ])
            ->add('description', TextareaType::class, [
                'label'=> 'description',
                'constraints'=>[
                    new Assert\NotBlank(),
                ]
                ])
            ->add('ingredient', CollectionType::class, [
                'attr'=> [
                    'class'=>'form-control'],
                'label'=>'ingreditents',
                'label_attr'=>[
                    'class'=>'form-label']
            ])
            ->add('stage', CollectionType::class, [
                'attr'=> [
                    'class'=>'form-control'],
                'label'=>'etapes',
                'label_attr'=>[
                    'class'=>'form-label']
            ])
            ->add('images', CollectionType::class, [
                'attr'=> [
                    'class'=>'form-control'],
                'label'=>'images',
                'label_attr'=>[
                    'class'=>'form-label']
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
            'data_class' => Recipes::class,
        ]);
    }
}
