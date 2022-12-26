<?php

namespace App\Form;

use App\Entity\Bien;
use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class BienType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'help' => 'Choose something catchy!'
            ])
            ->add('surface', IntegerType::class, [
                'attr' => [
                    'min' => 0
                ]
            ])
            ->add('price', IntegerType::class, [
                'attr' => [
                    'min' => 0
                ]
            ])
            ->add('description')
            ->add('country')
            ->add('postal_code')
            ->add('type', ChoiceType::class, [
                'choices'  => [
                    'Location' => 'location',
                    'Vente' => 'vente',
                ],
                'placeholder' => 'Chosir un type'
            ])
            ->add('category_id', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'libelle',
                'placeholder' => 'Chosir une catégorie'
            ])
            ->add('imageFile', FileType::class, [
                'mapped' => false,
                // 'required' => false,
                // 'constraints' => [
                //     new File([
                //         // 'maxSize' => '1024k',
                //         'mimeTypes' => [
                //             'image/*',
                //         ],
                //         'mimeTypesMessage' => 'Veuillez entrer une image valide',
                //     ])
                // ],
            ]);

            // 'choice_label' => function(User $user) {
            //     return sprintf('(%d) %s', $user->getId(), $user->getEmail());
            // }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Bien::class,
        ]);
    }
}
