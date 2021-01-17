<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\DoctrineORMAdminBundle\Filter\ModelAutocompleteFilter;

class MarkAdmin extends AbstractAdmin
{
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('student', ModelAutocompleteFilter::class, [], null, ['property' => 'name'])
            ->add('value')
            ->add('evaluation', ModelAutocompleteFilter::class, [], null, ['property' => 'name'])
            ->add('evaluation.section', ModelAutocompleteFilter::class, [], null, ['property' => 'name'])
            ->add('evaluation.affectedProgram', ModelAutocompleteFilter::class, [], null, ['property' => 'name'])
            ->add('evaluation.sequence', ModelAutocompleteFilter::class, [], null, ['property' => 'name'])
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('value', 'number', array('editable' => true))
            ->add('student')
            ->add('evaluation', 'html')
            ->add('evaluation.affectedProgram')
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
