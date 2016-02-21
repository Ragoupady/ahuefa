<?php

namespace SR\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MovieType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', [
                'attr'=> [
                    'class'=>'form-control','placeholder' => 'ex: "Matrix"'
                ],
                'label_attr' => [
                    'class' => 'col-sm-20 control-label'
                ],
                'label'=>'Titre du film',
                'required' => false,
            ])


            ->add('image', new ImageType(), [
                'attr'=> [
                    'class'=>'btn btn-default btn-file'
                ],
                'required'=>false,
            ])
            ->add('duration','time', [
                'widget' => 'choice',
                'attr'=> [
                    'class'=>'form-control'
                ],
                'label' => 'Durée du film',
                'required'=>false,
            ])

            ->add('year','text', [
                'attr'=> [
                    'class'=>'form-control',
                    'placeholder' => 'ex: "2002"'
                ],
                'label' => 'Année',
                'required'=>false,
            ])

            ->add('movieContent','textarea', [
                'attr'=> [
                    'class'=>'form-control'
                ],
                'label'=> 'Contenu du film',
                'required'=>false,
            ])
            ->add('author','text', [
                'attr'=> [
                    'class'=>'form-control'
                ],
                'label'=>'Nom de l\'auteur',
                'required'=>false,
            ])
            ->add('authoBio','textarea', [
                'attr'=> [
                    'class'=>'form-control'
                ],
                'label'=> 'A propos de l\'auteur',
                'required'=>false,
            ])
       
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SR\BlogBundle\Entity\Movie'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'sr_blogbundle_movie';
    }
}
