<?php

namespace App\Form;

use App\Data\SearchData;
use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchDataForm extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('q', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                ]
            ])
            ->add('country', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                ]
            ])
            ->add('type', ChoiceType::class, [
                'choices'  => [
                    'Location' => 'location',
                    'Vente' => 'vente',
                ],
                'required' => false,
            ])
            ->add('categories', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'libelle',
                'required' => false,
            ])
            // ->add('categories', EntityType::class, [
            //     'label' => false,
            //     'required' => false,
            //     'class' => Category::class,
            //     'expanded' => true,
            //     'multiple' => true
            // ]) 
            ->add('pricemin', NumberType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                ]
            ])
            ->add('pricemax', NumberType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                ]
            ])
            ->add('surfacemin', NumberType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    
                ]
            ])
            ->add('surfacemax', NumberType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    
                ]
            ]);
        // ->add('promo', CheckboxType::class, [
        //     'label' => 'En promotion',
        //     'required' => false,
        // ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SearchData::class,
            'method' => 'POST',
            'csrf_protection' => false
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
