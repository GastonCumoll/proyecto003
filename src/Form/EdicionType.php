<?php

namespace App\Form;

use DateTime;
use DateTimeInterface;
use App\Entity\Edicion;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class EdicionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        
        $fecha = new DateTime($options['fecha']);
        $builder
            ->add('fechaDeEdicion')
            ->add('cantidadImpresiones')
            ->add('fechaYHoraCreacion', DateType::class, [
                'attr'=>[
                    'value'=> $fecha,
                ]
            ])
            ->add('publicacion')
            ->add('usuarioCreador')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Edicion::class,
            'fecha' => NULL,
        ]);
    }
}
