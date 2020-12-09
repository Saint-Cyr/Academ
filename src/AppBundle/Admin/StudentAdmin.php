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
            ->add('section')
            ->add('name')       
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('name', null, array('editable' => true))
            ->add('section')
            ->add('studentParent')
            ->add('barcodeValue', null, array('editable' => true))
            //->add('barcode')
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
        ->with('Student Information', array('class' => 'col-md-4'))
            ->add('name')
            ->add('section', null, array('attr' => array('style' => 'width: 450px')))
            ->add('studentParent', null, array('attr' => array('style' => 'width: 450px')))
        ->end();
    }

    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->with('Student Information', array('class' => 'col-md-4'))
                ->add('id')
                ->add('name')
                ->add('barcode')
            ->end()
            ->with('Student Parent Information', array('class' => 'col-md-4'))
                ->add('student.studentParent', null, array('label' => 'Parent full Name'))
            ->end()
        ;
    }
    
    public function getExportFields() {
        return array('#ID'=>'id', 'Name'=>'name', 'Bar Code' => 'barcodeValue');
    }
    
    public function getExportFormats() {
        parent::getExportFormats();
        return ['xls', 'csv'];
    }
}
