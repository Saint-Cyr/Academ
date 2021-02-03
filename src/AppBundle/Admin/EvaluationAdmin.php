<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Form\Type\DateTimePickerType;
use Sonata\CoreBundle\Form\Type\DateTimeRangePickerType;
use Sonata\DoctrineORMAdminBundle\Filter\ModelAutocompleteFilter;

class EvaluationAdmin extends AbstractAdmin
{
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('sequence', ModelAutocompleteFilter::class, [], null, ['property' => 'name'])
            ->add('name')
            ->add('evaluationType', ModelAutocompleteFilter::class, [], null, ['property' => 'name'])
            ->add('affectedProgram.program', ModelAutocompleteFilter::class, ['label' => 'Program'], null, ['property' => 'name'])
            ->add('affectedProgram.section', ModelAutocompleteFilter::class, ['label' => 'Section'], null, ['property' => 'name'])
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('name', 'html', array('editable' => true))
            ->add('evaluationType')
            ->add('sequence')
            ->add('affectedProgram')
            ->add('affectedProgram.section', null, ['label' => 'Section'])
            //->add('average')
            ->add('createdAt', null, array('label' => 'Evaluation Date'))
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
                ->add('createdAt', DateTimePickerType::class, ['required' => false])
                ->add('name', 'html')
                ->add('sequence', null, array('attr' => array('style' => 'width: 450px')))
                ->add('name')
                ->add('evaluationType', null, array('attr' => array('style' => 'width: 455px')))
            ->end()
            ->with('Second section', array('class' => 'col-md-4'))
                ->add('affectedProgram', null, array('attr' => array('style' => 'width: 450px')))
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

    public function getExportFields() {
        return array('Barcode'=>'code', 'Sequence'=>'sequence', 'Type Evaluation'=>'evaluationType', 'Program'=>'affectedProgram', 'Section'=>'affectedProgram.section');
    }
    
    public function getExportFormats() {
        parent::getExportFormats();
        return ['xls', 'csv'];
    }
}
