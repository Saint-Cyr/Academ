<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class StudentAdmin extends AbstractAdmin
{
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            //->add('id')
            ->add('name')
            ->add('barcode')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            //->add('id')
            ->add('name')
            ->add('section')
            ->add('studentParent')
            ->add('barcode')
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
            //->add('id')
            ->add('name')
            ->add('section')
            ->add('studentParent')
            ->add('barcode')
        ;
    }

    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('name')
            ->add('barcode')
        ;
    }
}
