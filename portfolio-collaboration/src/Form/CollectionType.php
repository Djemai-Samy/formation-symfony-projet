<?php

namespace App\Form;

use App\Entity\Collection;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class CollectionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class, [
                'attr' => ['placeholder' => 'Entrez un titre pour la collection'],
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez entrer un titre.']),
                    new Length([
                        'min' => 3,
                        'max' => 50,
                        'minMessage' => 'Le titre doit comporter au moins {{ limit }} caractères',
                        'maxMessage' => 'Le titre ne peut pas dépasser {{ limit }} caractères',
                    ]),
                ],
            ])
            ->add('description', TextareaType::class, [
                'attr' => ['placeholder' => 'Décrivez votre collection.'],
                'constraints' => [
                    new Length([
                        'min' => 1,
                        'max' => 500,
                        'minMessage' => 'La description doit comporter au moins {{ limit }} caractères',
                        'maxMessage' => 'La description ne peut pas dépasser {{ limit }} caractères',
                    ]),
                ],
            ])
            ->add('isPublic', CheckboxType::class, ['required' => false])
            ->add('cover', FileType::class, [
                'label' => 'Avatar (PNG)',
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
            ->add(
                "tags",
                TextType::class,
                ["required" => false, 'attr' => ['placeholder' => 'Ajoutez des tags, séparé par des virgules. (exemple: vidéo,art,3d)'],]
            )
            ->add(
                "categorie",
                TextType::class,
                ['attr' => ['placeholder' => 'Entrez la categorie de la collection'],]
            )
        ;

        $builder->get('tags')
            ->addModelTransformer(new CallbackTransformer(
                function ($tagsAsArray) {
                    if ($tagsAsArray === null) {
                        return $tagsAsArray;
                    }
                    // transform the array to a string
                    return implode(',', $tagsAsArray);
                },
                function ($tagsAsString): array {
                    // transform the string back to an array
                    return explode(',', $tagsAsString);
                }
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Collection::class,
        ]);
    }
}
