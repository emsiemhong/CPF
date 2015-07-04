<?php

namespace NGS\ContentBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class ContactBooksAdmin extends Admin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('title', null, array('label' => 'Name'))
            ->add('description')
            ->add('created')
            ->add('picturePath', null, array('label' => 'Company Logo'))
            ->add('companyName')
            ->add('section')
            ->add('phone')
            ->add('email')
            ->add('address')
            ->add('fax')
            ->add('website')
            ->add('facebook')
            ->add('google')
            ->add('twitter')
            ->add('linkedin')
            ->add('instagram')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            // ->add('id')
            ->add('title', null, array('label' => 'Name'))
            // ->add('description')
            // ->add('created')
            // ->add('picturePath', null, array('label' => 'Company Logo'))
            ->add('companyName')
            ->add('section')
            ->add('phone')
            ->add('email')
            ->add('address')
            ->add('fax')
            ->add('website')
            ->add('facebook')
            // ->add('google')
            // ->add('twitter')
            // ->add('linkedin')
            // ->add('instagram')
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
        $contactBooks = $this->getSubject();
        // use $fileFieldOptions so we can add other options to the field
        $fileFieldOptions = array(
            'required' => false,
            'data_class' => null,
            'label' => 'Company Logo'
        );

        if ($contactBooks && ($webPath = $contactBooks->getWebPath())) {
            // get the container so the full path to the image can be set
            $container = $this->getConfigurationPool()->getContainer();
            $fullPath = $container->get('request')->getBasePath().'/'.$webPath;

            // add a 'help' option containing the preview's img tag
            $img = '<img src="'.$fullPath.'" class="admin-preview" style="width: 200px; height: 200px;" />';
            $fileFieldOptions['help'] = $img;
        }

        $formMapper
            ->add('title', 'text', array('label' => 'Name'))
            ->add('description', 'ckeditor', array('required' => false))
            ->add('picture', 'file', $fileFieldOptions)
            ->add('companyName', 'text', array('required' => false))
            ->add('section', 'sonata_type_model', array())
            ->add('phone', 'text', array('required' => false))
            ->add('email', 'text', array('required' => false))
            ->add('address', 'text', array('required' => false))
            ->add('fax', 'text', array('required' => false))
            ->add('website', 'text', array('required' => false))
            ->add('facebook', 'text', array('required' => false))
            ->add('google', 'text', array('required' => false))
            ->add('twitter', 'text', array('required' => false))
            ->add('linkedin', 'text', array('required' => false))
            ->add('instagram', 'text', array('required' => false))
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('title', null, array('label' => 'Name'))
            ->add('description')
            ->add('created')
            ->add('picturePath', null, array('label' => 'Company Logo'))
            ->add('companyName')
            ->add('section')
            ->add('phone')
            ->add('email')
            ->add('address')
            ->add('fax')
            ->add('website')
            ->add('facebook')
            ->add('google')
            ->add('twitter')
            ->add('linkedin')
            ->add('instagram')
        ;
    }

    public function prePersist($contactBooks)
    {
        $user = $this
            ->getConfigurationPool()
            ->getContainer()
            ->get('security.token_storage')
            ->getToken()
            ->getUser()
        ;
        $contactBooks->setPostedBy($user);

        $contactBooks->preUpload();
    }

    public function preUpdate($contactBooks)
    {
        $user = $this
            ->getConfigurationPool()
            ->getContainer()
            ->get('security.token_storage')
            ->getToken()
            ->getUser()
        ;
        $contactBooks->setPostedBy($user);

        $contactBooks->preUpload();
    }

    public function postPersist($contactBooks)
    {
        $contactBooks->upload();
    }

    public function postUpdate($contactBooks)
    {
        $contactBooks->upload();
    }
}
