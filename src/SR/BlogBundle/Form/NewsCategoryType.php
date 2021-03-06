<?php

namespace SR\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class NewsCategoryType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name','text', [
                'label' => 'Nom de la catégorie'
            ])
            ->add('Creer','submit', [
                'attr' => [
                  'class' => 'btn btn-info'
                ],
            ])
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SR\BlogBundle\Entity\NewsCategory'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'sr_blogbundle_newscategory';
    }
}
