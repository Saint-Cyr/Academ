<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class StudentParentAdmin extends AbstractAdmin
{
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('firstname', null, ['editable' => true])
            ->add('name', null, ['editable' => true])
            ->add('profession', null, ['editable' => true])
            ->add('phoneNumber', null, ['editable' => true])
            ->add('adress', null, ['editable' => true])
            ->add('email', 'email', ['editable' => true])
            ->add('students')
            ->add('_action', null, [
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => [],
                ],
            ])
        ;
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
        ->with('Student Parent Information', array('class' => 'col-md-4'))
            ->add('name')
            ->add('students', null, ['attr' => ['style' => 'width: 515px'], 'label' => 'Students'])
            ->add('profession')
            ->add('email', 'email', ['required' => false])
        ->end();
    }

    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('name')
        ;
    }
}
