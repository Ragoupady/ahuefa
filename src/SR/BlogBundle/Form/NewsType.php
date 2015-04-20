<?php

namespace SR\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class NewsType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title','text')
            ->add('content','textarea',array('attr'=> array('class'=>'ckeditor')))
            ->add('image', new ImageType(),array('required'=>false))
            ->add('newsDate','date')
            ->add('newsStatus','checkbox', array('required' => false))
            ->add('newsCategories','entity',array('class'=>'SRBlogBundle:NewsCategory',
                                                  'property'=> 'name',
                                                  'multiple'=> true))
            
            ->add('envoyer','submit')

        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SR\BlogBundle\Entity\News'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'sr_blogbundle_news';
    }
}
