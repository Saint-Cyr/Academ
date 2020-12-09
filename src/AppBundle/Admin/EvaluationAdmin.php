<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Form\Type\DateTimePickerType;
use Sonata\CoreBundle\Form\Type\DateTimeRangePickerType;

class EvaluationAdmin extends AbstractAdmin
{
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('sequence')
            ->add('createdAt')
            ->add('name')
            ->add('evaluationType')
            ->add('program')
            ->add('section')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('sequence')
            ->add('name', 'html', array('editable' => true))
            ->add('evaluationType')
            ->add('program')
            ->add('section')
            //->add('average')
            ->add('createdAt')
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
            ->with('Information', array('class' => 'col-md-4'))
                ->add('createdAt', DateTimePickerType::class)
                ->add('name', 'html')
                ->add('sequence', null, array('attr' => array('style' => 'width: 450px')))
                ->add('name')
                ->add('evaluationType', null, array('attr' => array('style' => 'width: 455px')))
                ->add('program', null, array('attr' => array('style' => 'width: 450px')))
            ->end()
            ->with('Second section', array('class' => 'col-md-4'))
                ->add('section', null, array('attr' => array('style' => 'width: 450px')))
            ->end()
        ;
    }

    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('createdAt')
            ->add('name', 'html')
        ;
    }
}
