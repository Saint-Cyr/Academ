<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class SettingAdmin extends AbstractAdmin
{
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            //->add('id')
            ->add('name')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            //->add('id')
            ->add('name')
            ->add('sequence')
            ->add('definedYearlySequenceNumber', null, array('editable' => true))
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
            ->with('General', array('class' => 'col-md-3'))
                ->add('schoolName')
                ->add('academicYear')
            ->end()
            ->with('Sequence', array('class' => 'col-md-3'))
                ->add('sequence')
                ->add('definedYearlySequenceNumber')
            ->end()
            ->with('Technical Info.', array('class' => 'col-md-3'))
                ->add('name', null, array('disabled' => true))
            ->end()
            ;
    }

    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            //->add('id')
            ->add('name')
            ->add('sequence')
        ;
    }
}
