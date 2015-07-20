<?php

namespace NGS\ContentBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ContactBookType extends AbstractType
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
                        'label' => $this->translator->trans('name')
                    ),
                    'description' => array (
                        'field_type' => 'ckeditor',
                        'label' => $this->translator->trans('description')
                    )
                ),
            ))
            ->add('picture', 'file', array(
                'label' => $this->translator->trans('logo'),
                'required' => false
            ))
            ->add('companyName', 'text', array(
                'label' => $this->translator->trans('company_name'),
                'required' => false
            ))
            ->add('phone', 'text', array(
                'label' => $this->translator->trans('phone'),
                'required' => false
            ))
            ->add('email', 'text', array(
                'label' => $this->translator->trans('email'),
                'required' => false
            ))
            ->add('address', 'text', array(
                'label' => $this->translator->trans('address'),
                'required' => false
            ))
            ->add('website', 'text', array(
                'label' => $this->translator->trans('website'),
                'required' => false
            ))
            ->add('facebook', 'text', array(
                'label' => 'Facebook',
                'required' => false
            ))
            ->add('twitter', 'text', array(
                'label' => 'Twitter',
                'required' => false
            ))
            ->add('section', 'entity', array(
                'class' => 'NGSContentBundle:ContactBookSection',
                'label' => $this->translator->trans('section')
            ))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'NGS\ContentBundle\Entity\ContactBook'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ngs_contentbundle_contactbooks';
    }
}
