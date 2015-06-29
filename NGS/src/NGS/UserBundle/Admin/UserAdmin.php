<?php

namespace NGS\UserBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class UserAdmin extends Admin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('username')
            ->add('usernameCanonical')
            ->add('email')
            ->add('emailCanonical')
            ->add('enabled')
            ->add('salt')
            ->add('password')
            ->add('lastLogin')
            ->add('locked')
            ->add('expired')
            ->add('expiresAt')
            ->add('confirmationToken')
            ->add('passwordRequestedAt')
            ->add('roles')
            ->add('credentialsExpired')
            ->add('credentialsExpireAt')
            ->add('id')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('username')
            ->add('usernameCanonical')
            ->add('email')
            ->add('emailCanonical')
            ->add('enabled', null, array('editable' => true))
            ->add('lastLogin')
            ->add('locked')
            ->add('expired')
            ->add('expiresAt')
            ->add('confirmationToken')
            ->add('passwordRequestedAt')
            ->add('roles')
            ->add('credentialsExpired')
            ->add('credentialsExpireAt')
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
        if ($this->isGranted('ROLE_ADMIN')) {
            $formMapper
                ->add('username')
                ->add('usernameCanonical')
                ->add('email')
                ->add('emailCanonical')
                ->add('enabled')
                ->add('plainPassword', 'text', array('required' => false))
                ->add('locked')
                ->add('roles')
            ;
        }
        // $formMapper
        //     ->with('General')
        //         ->add('username')
        //         ->add('email')
        //         ->add('enabled')
        //         ->add('plainPassword', 'text', array('required' => false))
        //     ->end()
        // ;
            if ($this->isGranted('ROLE_SUPER_ADMIN')) {
                $formMapper
                    ->add('roles')
                ;
            }
            // ->with('Management')
            //     ->add('roles', 'sonata_security_roles', array( 'multiple' => true))
            //     ->add('locked', null, array('required' => false))
            //     ->add('expired', null, array('required' => false))
            //     ->add('enabled', null, array('required' => false))
            //     ->add('credentialsExpired', null, array('required' => false))
            // ->end()
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('username')
            ->add('usernameCanonical')
            ->add('email')
            ->add('emailCanonical')
            ->add('enabled')
            ->add('salt')
            ->add('password')
            ->add('lastLogin')
            ->add('locked')
            ->add('expired')
            ->add('expiresAt')
            ->add('confirmationToken')
            ->add('passwordRequestedAt')
            ->add('roles')
            ->add('credentialsExpired')
            ->add('credentialsExpireAt')
            ->add('id')
        ;
    }
}
