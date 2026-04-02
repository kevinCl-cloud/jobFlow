<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'attr' => [
                    'class'=> 'form-field',
                    'placeholder' => 'email@exemple.com'
                ]
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options'  => ['label' => 'Mot de passe',
                 'hash_property_path' => 'password',
                 'attr' => [ 
                    'class' => 'form-field',
                    'placeholder' => 'Entrez votre mot de passe' ]
                 ],
                'second_options' => ['label' => 'Confirmez le mot de passe', 
                'attr' => [
                    'class' => 'form-field',
                    'placeholder' => 'Confirmez votre mot de passe']
                ],
                'mapped' => false,
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Nom',
                'attr' => [
                    'class'=> 'form-field',
                    'placeholder' => 'Veuillez entrer votre nom']
            ])
            ->add('firstName', TextType::class, [
                'label' => 'Prénom',
                'attr' => [
                    'class'=> 'form-field',
                    'placeholder' => 'Veuillez entrer votre prenom']
            ])
            ->add('telNumber', TextType::class, [
                'label' => 'Numero de téléphone',
                'attr' => [
                    'class'=> 'form-field',
                    'placeholder' => 'ex : 0606060606']
            ])
            ->add('location', TextType::class, [
                'label' => 'Ville',
                'attr' => [
                    'class'=> 'form-field',
                    'placeholder' => 'Veuillez entrer le nom de votre ville']
            ])
            ->add("validez", SubmitType::class, [
                'attr'=> [
                    'style' => 'background-color: var(--bouton-couleur);
                    border-radius: 15px;
                    padding: 10px 20px;']
            ] )
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
