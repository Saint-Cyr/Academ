<?php

declare(strict_types=1);

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\DoctrineORMAdminBundle\Filter\ModelAutocompleteFilter;

final class AffectedProgramAdmin extends AbstractAdmin
{
    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            ->add('teacher', ModelAutocompleteFilter::class, [], null, ['property' => 'name'])
            ->add('program', ModelAutocompleteFilter::class, [], null, ['property' => 'name'])
            ->add('section', ModelAutocompleteFilter::class, [], null, ['property' => 'name'])
            ->add('section.level', ModelAutocompleteFilter::class, ['label' => 'Level'], null, ['property' => 'name'])
            
        ;
    }

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            ->add('id', null, ['header_style' => 'width: 2%;'])
            ->add('section')
            ->add('name')
            //->add('program')
            //->add('program.level')
            ->add('teacher')
            ->add('_action', null, [
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => [],
                ],
            ])
        ;
    }

    protected function configureFormFields(FormMapper $formMapper): void
    {
        $formMapper
        ->with('Section Information', array('class' => 'col-md-4'))
            ->add('program', null, array('attr' => array('style' => 'width: 450px')))
            ->add('section', null, array('attr' => array('style' => 'width: 450px')))
            ->add('teacher', null, array('attr' => array('style' => 'width: 450px')))
        ->end();
    }

    protected function configureShowFields(ShowMapper $showMapper): void
    {
        $showMapper
            ->add('id')
            ->add('name')
        ;
    }
}
