<?php

namespace NGS\ContentBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class AnnouncementAdmin extends Admin
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
            ->add('date')
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
            ->add('title')
            ->add('description')
            ->add('picturePath')
            ->add('postedBy')
            ->add('date')
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
        $announcement = $this->getSubject();
        // use $fileFieldOptions so we can add other options to the field
        $fileFieldOptions = array('required' => false, 'data_class' => null);
        if ($announcement && ($webPath = $announcement->getWebPath())) {
            // get the container so the full path to the image can be set
            $container = $this->getConfigurationPool()->getContainer();
            $fullPath = $container->get('request')->getBasePath().'/'.$webPath;

            // add a 'help' option containing the preview's img tag
            $img = '<img src="'.$fullPath.'" class="admin-preview" style="width: 200px; height: 200px;" />';
            $fileFieldOptions['help'] = $img;
        }

        $formMapper
            ->add('title')
            ->add('description')
            ->add('date')
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
            ->add('title')
            ->add('description')
            ->add('date')
            ->add('picturePath', null, array('label' => 'Picture'))
            ->add('postedBy')
        ;
    }

    public function prePersist($announcement)
    {
        $user = $this
            ->getConfigurationPool()
            ->getContainer()
            ->get('security.token_storage')
            ->getToken()
            ->getUser()
        ;
        $announcement->setPostedBy($user);

        $announcement->preUpload();
    }

    public function preUpdate($announcement)
    {
        $user = $this
            ->getConfigurationPool()
            ->getContainer()
            ->get('security.token_storage')
            ->getToken()
            ->getUser()
        ;
        $announcement->setPostedBy($user);

        $announcement->preUpload();
    }

    public function postPersist($announcement)
    {
        $announcement->upload();
    }

    public function postUpdate($announcement)
    {
        $announcement->upload();
    }
}
