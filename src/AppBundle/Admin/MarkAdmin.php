<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class MarkAdmin extends AbstractAdmin
{
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('student')
            ->add('value')
            ->add('evaluation.evaluationType')
            ->add('evaluation.section')
            ->add('evaluation.program')
            ->add('evaluation.sequence')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('value', 'number', array('editable' => true))
            ->add('student')
            ->add('evaluation', 'html')
            ->add('evaluation.program')
            ->add('evaluation.sequence')
            
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
        ->with('Student Mark Information', array('class'=>'col-md-4'))
            ->add('value', null, array('attr' => array('style' => 'width: 455px'),
                                         'disabled' => true))
            ->add('student', null, array('attr' => array('style' => 'width: 455px'),
                                         'disabled' => true))
            ->add('evaluation', null, array('attr' => array('style' => 'width: 455px'),
                                         'disabled' => true))
            ->add('student.section', null, array('attr' => array('style' => 'width: 455px'),
                                         'disabled' => true))
        ->end()
            
        ;
    }

    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('value')
        ;
    }
}
