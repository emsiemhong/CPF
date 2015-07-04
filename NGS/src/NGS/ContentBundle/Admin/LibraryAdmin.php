<?php

namespace NGS\ContentBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class LibraryAdmin extends Admin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('title')
            ->add('description')
            ->add('created')
            ->add('picturePath', null, array('label' => 'Cover'))
            ->add('filePath')
            ->add('author')
            ->add('downloadable')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('title')
            ->add('description')
            ->add('created')
            ->add('picturePath')
            ->add('filePath')
            ->add('author')
            ->add('downloadable', null, array('editable' => true))
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
        $library = $this->getSubject();
        // use $fileFieldOptions so we can add other options to the field
        $fileFieldOptions = array(
            'required' => false,
            'data_class' => null,
            'label' => 'Cover'
        );

        if ($library && ($webPath = $library->getWebPath())) {
            // get the container so the full path to the image can be set
            $container = $this->getConfigurationPool()->getContainer();
            $fullPath = $container->get('request')->getBasePath().'/'.$webPath;

            // add a 'help' option containing the preview's img tag
            $img = '<img src="'.$fullPath.'" class="admin-preview" style="width: 200px; height: 200px;" />';
            $fileFieldOptions['help'] = $img;
        }

        $formMapper
            ->add('title')
            ->add('description', 'ckeditor', array('required' => false))
            ->add('picture', 'file', $fileFieldOptions)
            ->add('file', 'file', array(
                'required' => false,
                'data_class' => null,
                'label' => 'Pdf file'
            ))
            ->add('author')
            ->add(
                'downloadable',
                'checkbox',
                array('attr' => array('checked' => true)
            ))
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('title')
            ->add('description')
            ->add('created')
            ->add('picturePath', null, array('label' => 'Cover'))
            ->add('author')
            ->add('downloadable')
            ->add('filePath')
        ;
    }

    public function prePersist($library)
    {
        $user = $this
            ->getConfigurationPool()
            ->getContainer()
            ->get('security.token_storage')
            ->getToken()
            ->getUser()
        ;
        $library->setPostedBy($user);

        $library->preUpload();
        $library->preUploadFile();
    }

    public function preUpdate($library)
    {
        $user = $this
            ->getConfigurationPool()
            ->getContainer()
            ->get('security.token_storage')
            ->getToken()
            ->getUser()
        ;
        $library->setPostedBy($user);

        $library->preUpload();
        $library->preUploadFile();
    }

    public function postPersist($library)
    {
        $library->upload();
        $library->uploadFile();
    }

    public function postUpdate($library)
    {
        $library->upload();
        $library->uploadFile();
    }
}
