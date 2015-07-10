<?php

namespace NGS\ContentBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use NGS\ContentBundle\Entity\Article;

class ArticleType extends AbstractType
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
                'locales' => array('en_US', 'km_KH'),
                'required_locales' => array('en_US'),
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
            ->add('type', 'choice', array(
                'choices' => array(
                    Article::ABOUT_TYPE => $this->translator->trans('about'),
                    Article::SERVICE_TYPE => $this->translator->trans('service'),
                    Article::HOME_TYPE => $this->translator->trans('home')
                )
            ))
            ->add('picture', 'file', array(
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
            'data_class' => 'NGS\ContentBundle\Entity\Article'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ngs_contentbundle_articles';
    }
}
