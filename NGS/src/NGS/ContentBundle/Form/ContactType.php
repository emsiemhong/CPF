<?php

namespace NGS\ContentBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Translation\TranslatorInterface;
// use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ContactType extends AbstractType
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
            ->add('name', 'text', array(
                'label' => $this->translator->trans('name')
            ))
            ->add('email', 'email', array(
                'label' => $this->translator->trans('email')
            ))
            ->add('subject', 'text', array(
                'label' => $this->translator->trans('subject')
            ))
            ->add('body', 'ckeditor', array(
                'label' => $this->translator->trans('message')
            ))
            ->add('send', 'submit');
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ngs_contentbundle_contact';
    }
}
