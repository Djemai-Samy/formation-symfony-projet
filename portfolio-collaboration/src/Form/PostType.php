<?php

namespace App\Form;

use App\Entity\Collection;
use App\Entity\Post;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class, [
                'attr' => ['placeholder' => 'Entrez un titre pour le post'],
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez entrer un titre']),
                    new Length([
                        'min' => 3,
                        'max' => 50,
                        'minMessage' => 'Le titre doit comporter au moins {{ limit }} caractères',
                        'maxMessage' => 'Le titre ne peut pas dépasser {{ limit }} caractères',
                    ]),
                ],
            ])
            ->add('description', TextareaType::class, [
                'attr' => ['placeholder' => 'Décrivez votre post.'],
                'constraints' => [
                    new Length([
                        'min' => 1,
                        'max' => 500,
                        'minMessage' => 'Le post doit comporter au moins {{ limit }} caractères',
                        'maxMessage' => 'Le post ne peut pas dépasser {{ limit }} caractères',
                    ]),
                ],
            ])
            ->add('image', FileType::class, [
                'label' => 'Image (PNG)',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '4096k',
                        'mimeTypes' => [
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Veuillez charger une image de format png.',
                    ])
                ],
            ])
            ->add('isPublic', CheckboxType::class, ['required' => false])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
