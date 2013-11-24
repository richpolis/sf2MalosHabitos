<?php

namespace Richpolis\PublicacionesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Richpolis\PublicacionesBundle\Entity\Publicacion;
use Richpolis\PublicacionesBundle\Repository\CategoriasPublicacionRepository;

class PublicacionArtistasType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titulo','text',array('label'=>'Artista'))
            ->add('descripcion','textarea', array(
                    'attr' => array(
                        'class' => 'tinymce',
                        'data-theme' => 'advanced' // Skip it if you want to use default theme
                    ),'label'=>'Descripcion'
                ))
            ->add('categoria','entity', array(
                'class' => 'PublicacionesBundle:CategoriasPublicacion',
                'query_builder' => function(CategoriasPublicacionRepository $er) {
                        return $er->createQueryBuilder('u')
                                ->orderBy('u.id', 'ASC');
                },
                'property'  => 'categoria',
                'label'     => 'Categoria',
                'multiple'  => false
            ))
            ->add('twitter','text')
            ->add('facebook','text')            
            ->add('posicion','hidden')
            ->add('galeria','hidden')
            ->add('slug','hidden')
            ->add('isActive',null,array('label'=>'Activo?','required'=>false))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Richpolis\PublicacionesBundle\Entity\Publicacion'
        ));
    }

    public function getName()
    {
        return 'richpolis_publicacionesbundle_publicacion_artistastype';
    }
}
