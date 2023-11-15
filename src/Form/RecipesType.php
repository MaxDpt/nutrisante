<?php

namespace App\Form;

use App\Entity\Recipes;
use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Form\Type\VichImageType;

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
            ->add('description', TextareaType::class, [
                'label'=> 'description',
                'constraints'=>[
                    new Assert\NotBlank(),
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
            ->add('ingredient', CollectionType::class, [
                'attr'=> [
                    'class'=>'form-control'],
                'label'=>'ingreditents',
                'label_attr'=>[
                    'class'=>'form-label'],
                'entry_type'=> TextType::class,
                'by_reference'=>false,
                "allow_add"=>true,
                "allow_delete"=>true

            ])
            ->add('stage', CollectionType::class, [
                'attr'=> [
                    'class'=>'form-control'],
                'label'=>'etapes',
                'label_attr'=>[
                    'class'=>'form-label'],
                    'entry_type'=> TextareaType::class,
                    'by_reference'=>false,
                    "allow_add"=>true,
                    "allow_delete"=>true
            ])
            ->add('user', IntegerType::class, [
                'attr'=> [
                    'class'=>'form-control',
                    'id' => 'userId',
                    'hidden' => true],
                'label' => 'utilisateur',
                'label_attr' =>[
                    'class' => 'form-label'],
                'required' => false,
            ])
            ->add('imageFile', VichImageType::class, [
                'attr'=> [
                    'class'=>'form-control'],
                'label'=>'images',
                'label_attr'=>[
                    'class'=>'form-label'],
                'required' => false,
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
