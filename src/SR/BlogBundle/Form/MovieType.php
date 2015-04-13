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
            ->add('title', 'text',array('attr'=> array('class'=>'form-control','placeholder' => 'ex: "Matrix"'),
                                        'label_attr' => array('class' => 'col-sm-20 control-label')))


            ->add('image', new ImageType(),array('attr'=> array('class'=>'btn btn-default btn-file')) )
            ->add('duration','time', array('widget' => 'choice',
                                            'attr'=> array('class'=>'form-control')))

            ->add('year','text',array('attr'=> array('class'=>'form-control','placeholder' => 'ex: "2002"')))
            ->add('movieContent','textarea',array('attr'=> array('class'=>'form-control')))
            ->add('author','text',array('attr'=> array('class'=>'form-control')))
            ->add('authoBio','textarea',array('attr'=> array('class'=>'form-control')))
       
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
