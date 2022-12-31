<?php

namespace App\Form;

use App\Entity\SearchedProperty;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchedPropertyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('email', EmailType::class)
            ->add('type', ChoiceType::class, [
                'choices'  => [
                    'Location' => 'location',
                    'Vente' => 'vente',
                ],
                'placeholder' => 'Chosir un type'
            ])
            ->add('minprice')
            ->add('maxprice')
            ->add('minsurface')
            ->add('maxsurface')
            ->add('country');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SearchedProperty::class,
        ]);
    }
}
