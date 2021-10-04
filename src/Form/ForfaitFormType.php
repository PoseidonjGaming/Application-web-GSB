<?php

namespace App\Form;

use App\Entity\Forfait;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ForfaitFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('qte')
            
            
        ;
        $builder->add('leType', [
            'entry_type' => TypeFraisFormType::class,
            'entry_options' => ['label' => false],
            'allow_add' => true,
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Forfait::class,
        ]);
    }
}
