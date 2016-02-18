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
            ->add('title','text', [
                'label' => 'Titre'
            ])
            ->add('content','textarea',[
                'label' => 'Contenu',
                'attr' => ['cols' => '5', 'rows' => '30'],
            ])
            ->add('newsDate','date',  [
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
                'label' => 'Date de publication',
                'attr' => ['class' => 'datepicker']
            ])
            ->add('newsStatus','checkbox', [
                'label' => 'publié',
                'required' => false,
            ])
            ->add('newsCategories','entity', [
                'label' => 'Catégorie(s)',
                'class'=>'SRBlogBundle:NewsCategory',
                'property'=> 'name',
                'multiple'=> true,
            ])
            ->add('image', new ImageType(), [
                'required'=>false,
            ])
            ->add('envoyer','submit', [
                'attr' => [
                    'class' => 'btn btn-info'
                ],
                'label' => 'Ajouter'
            ])
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
