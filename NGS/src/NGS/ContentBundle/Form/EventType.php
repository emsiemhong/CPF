<?php

namespace NGS\ContentBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EventType extends AbstractType
{
    private $translator;

    public function __construct(TranslatorInterface $translator) {
        $this->translator = $translator;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('translations', 'a2lix_translations', array (
                'locales' => array('en', 'km'),
                'required_locales' => array('en'),
                'label' => false,
                'fields' => array(
                    'title' => array (
                        'field_type' => 'text',
                        'label' => $this->translator->trans('title')
                    ),
                    'description' => array (
                        'field_type' => 'ckeditor',
                        'label' => $this->translator->trans('description')
                    )
                ),
            ))
            ->add('date', 'date', array(
                'days' => range(1, 31)
            ))
            ->add('picture')
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'NGS\ContentBundle\Entity\Event'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ngs_contentbundle_event';
    }
}
