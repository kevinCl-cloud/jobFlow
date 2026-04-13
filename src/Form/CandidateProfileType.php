<?php

namespace App\Form;

use App\Entity\CandidateProfile;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class CandidateProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('proTitle', TextType::class, [
                'label' => 'Titre professionnel',
                'attr' => [
                    'class' => 'form-field',
                    'placeholder' => 'Ex : Developpeur web junior',
                ],
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Presentation',
                'attr' => [
                    'class' => 'form-field',
                    'placeholder' => 'Parlez de votre parcours, de vos competences et de ce que vous recherchez.',
                    'rows' => 5,
                ],
            ])
            ->add('cvFile', FileType::class, [
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File(
                        maxSize: '5024k',
                        extensions: ['pdf'],
                        extensionsMessage: 'Veuillez televerser un document PDF valide.',
                    ),
                ],
                'attr' => [
                    'class' => 'form-field',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CandidateProfile::class,
        ]);
    }
}
