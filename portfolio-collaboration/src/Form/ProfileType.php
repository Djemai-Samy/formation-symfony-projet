<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Url;

class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('pseudo', TextType::class, [
                'attr' => ['placeholder' => 'Choisissez un nom d\'utilisateur'],
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez entrer un nom d\'utilisateur']),
                    new Length([
                        'min' => 3,
                        'max' => 50,
                        'minMessage' => 'Votre nom d\'utilisateur doit comporter au moins {{ limit }} caractères',
                        'maxMessage' => 'Votre nom d\'utilisateur ne peut pas dépasser {{ limit }} caractères',
                    ]),
                ],
            ])
            ->add('description', TextareaType::class, [
                'required' => false,
                'attr' => ['placeholder' => 'Entrez votre description.'],
                'constraints' => [
                    new Length([
                        'max' => 500,
                        'maxMessage' => 'Votre déscription ne peut pas dépasser {{ limit }} caractères',
                    ]),
                ],
            ])
            ->add('emploi', TextType::class, [
                'required' => false,
                'attr' => ['placeholder' => 'Entrez votre description.'],
                'constraints' => [
                    new Length([
                        'max' => 500,
                        'maxMessage' => 'Votre déscription ne peut pas dépasser {{ limit }} caractères',
                    ]),
                ],
            ])
            ->add('telephone', TelType::class, [
                'required' => false,
                'attr' => ['placeholder' => 'Entrez votre numéro de téléphone.'],
                'constraints' => [
                    new Length([
                        'max' => 20,
                        'maxMessage' => 'Votre nuémaro de téléphone ne peut pas dépasser {{ limit }} caractères',
                    ]),
                ],
            ])
            ->add('siteURL', UrlType::class, [
                "label" => "Site web",
                'required' => false,
                'attr' => ['placeholder' => 'Entrez votre site web personnel.'],
                'constraints' => [
                    new Url([
                        'message' => "Cette url n'est pas valide.",
                    ]),
                ],
            ])
            ->add('avatar', FileType::class, [
                'label' => 'Avatar (PNG)',

                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,

                // unmapped fields can't define their validation using attributes
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Veuillez charger une image de format png.',
                    ])
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Enregistrer',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
