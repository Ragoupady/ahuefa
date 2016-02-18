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
            ->add('eventCategory', 'entity',[
                'class'=>'SRBlogBundle:EventCategory',
                'property'=> 'name',
                'multiple'=> false,
                'label' => 'Type d\'événement',
            ])
            ->add('title','text', [
                'label' => 'Titre',
            ])
            ->add('image', new ImageType(), [
                'required'=>false,
            ])
            ->add('content','textarea', [
                'label' => 'Description',
                'attr' => ['cols' => '5', 'rows' => '30'],
            ])
            ->add('postDate','date',  [
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
                'label' => 'Date de publication',
                'attr' => ['class' => 'datepicker']
            ])
            ->add('status','checkbox', [
                'required'=>false,
            ])
            ->add('eventStatus','checkbox', [
                'required'=>false,
            ])
            ->add('eventStartDate','date', [
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
                'label' => 'Date début',
                'attr' => ['class' => 'datepicker']
            ])
            ->add('eventEndDate','date', [
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
                'label' => 'Date de fin',
                'attr' => ['class' => 'datepicker']
            ])
            ->add('eventRate','text', [
                'label' => 'Prix',
            ])
            ->add('movies', 'collection', [
                'type' => new MovieType(),
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete'=> true,
            ])
            ->add('eventGuest','text', [
                'required'=>false,
            ])
            ->add('eventLocation','text', [
                'attr'=> [
                    'placeholder' => 'ex: "104 Avenue Jean Lolive, 93500 Pantin"',
                    'required'=>false,
                    'label' => 'Les invités',
                ]
            ])
            ->add('envoyer','submit', [
                'attr' => [
                    'class' => 'btn-info',
                ]
            ])
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
