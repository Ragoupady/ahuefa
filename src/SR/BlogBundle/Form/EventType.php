<?php

namespace SR\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EventType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('eventCategory', 'entity',array(
                                                    'class'=>'SRBlogBundle:EventCategory',
                                                    'property'=> 'name',
                                                    'multiple'=> false))
            ->add('title','text')
            ->add('image', new ImageType())
            ->add('content','textarea',array('attr'=> array('class'=>'ckeditor')))
            ->add('postDate','date')
            ->add('status','checkbox')
            ->add('eventStatus','checkbox')
            ->add('eventStartDate','date')
            ->add('eventEndDate','date')
            ->add('eventRate','text')
            ->add('movies', 'collection', array(
                                          'type' => new MovieType(),
                                          'by_reference' => false,
                                          'allow_add' => true,
                                          'allow_delete'=> true))
            ->add('eventGuest','text')
            ->add('eventLocation')
            ->add('envoyer','submit')
           // ->add('tags')
          //  ->add('news')
          //  ->add('user')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SR\BlogBundle\Entity\Event'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'sr_blogbundle_event';
    }
}
