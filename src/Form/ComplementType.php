<?php

namespace App\Form;

use App\Entity\Complement;
use App\Entity\Plat;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ComplementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            
            ->add('nom', TextType::class, ['label' => false,'required' => false])
            ->add('prix', TextType::class, ['label' => false,'required' => false,])
            ->add('type', choiceType::class, ['label' => false,
            'mapped' => false,
            'required' => false,
            'choices' => [
                    'Boisson' => 'boisson' ,
                    'Fritte' =>'fritte' ,
                   
                ],
            
            ])
            ->add('image', FileType::class, [
                'label' => false,
                'multiple' => true,
                'mapped' => false,
                'required' => false
            ])
           
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Plat::class,
        ]);
    }
}
