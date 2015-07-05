<?php

namespace NGS\ContentBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class ArticlesAdmin extends Admin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            // ->add('title')
            // ->add('description')
            ->add('type')
            ->add('picturePath', null, array('label' => 'Picture'))
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            // ->add('title')
            // ->add('description')
            ->add('type')
            // ->add('picturePath')
            // ->add('postedBy')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        // get the current Image instance
        $articles = $this->getSubject();
        // use $fileFieldOptions so we can add other options to the field
        $fileFieldOptions = array('required' => false, 'data_class' => null);
        if ($articles && ($webPath = $articles->getWebPath())) {
            // get the container so the full path to the image can be set
            $container = $this->getConfigurationPool()->getContainer();
            $fullPath = $container->get('request')->getBasePath().'/'.$webPath;

            // add a 'help' option containing the preview's img tag
            $img = '<img src="'.$fullPath.'" class="admin-preview" style="width: 200px; height: 200px;" />';
            $fileFieldOptions['help'] = $img;
        }

        $formMapper
            // ->add('title')
            // ->add('description', 'ckeditor', array('required' => false))
            ->add('translations', 'a2lix_translations', array(
                'by_reference' => false,
                'locales' => array('English', 'Khmer'),
                'fields' => array(
                    'title' => array(
                        'label' => 'Title',
                        'field_type' => 'text'
                    ),
                    'description' => array(
                        'label' => 'Description',
                        'field_type' => 'ckeditor'
                    )
                )
            ))
            ->add('type', 'sonata_type_model')
            ->add('picture', 'file', $fileFieldOptions)
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            // ->add('title')
            // ->add('description')
            ->add('type')
            ->add('picturePath', null, array('label' => 'Picture'))
            ->add('postedBy')
        ;
    }

    public function prePersist($articles)
    {
        $user = $this
            ->getConfigurationPool()
            ->getContainer()
            ->get('security.token_storage')
            ->getToken()
            ->getUser()
        ;
        $articles->setPostedBy($user);

        $articles->preUpload();
    }

    public function preUpdate($articles)
    {
        $user = $this
            ->getConfigurationPool()
            ->getContainer()
            ->get('security.token_storage')
            ->getToken()
            ->getUser()
        ;
        $articles->setPostedBy($user);

        $articles->preUpload();
    }

    public function postPersist($articles)
    {
        $articles->upload();
    }

    public function postUpdate($articles)
    {
        $articles->upload();
    }
}
