<?php

namespace NGS\ContentBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class LibraryType extends AbstractType
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
                        'label' => $this->translator->trans('title'),
                        'required' => true
                    ),
                    'description' => array (
                        'field_type' => 'ckeditor',
                        'label' => $this->translator->trans('description'),
                        'required' => true
                    )
                ),
            ))
            ->add('picture', 'file', array(
                'label' => $this->translator->trans('cover'),
                'required' => false
            ))
            ->add('downloadable', 'checkbox', array(
                'label' => $this->translator->trans('downloadable'),
                'required' => false
            ))
            ->add('file', 'file', array(
                'label' => $this->translator->trans('pdf_file'),
                'required' => false
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'NGS\ContentBundle\Entity\Library'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ngs_contentbundle_library';
    }
}
