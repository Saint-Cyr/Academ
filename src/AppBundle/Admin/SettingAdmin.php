<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\LanguageType;

class SettingAdmin extends AbstractAdmin
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
            ->add('name')
            ->add('sequence')
            ->add('language')
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
            ->with('School Information', array('class' => 'col-md-3'))
                ->add('schoolName')
                ->add('academicYear')
            ->end()
            ->with('Sequence parameters', array('class' => 'col-md-3'))
                ->add('sequence', null, array('attr' => array('style' => 'width: 330px')))
                ->add('definedYearlySequenceNumber')
            ->end()
            ->with('More setting.', array('class' => 'col-md-3'))
                ->add('name', null, array('disabled' => true))
                ->add('language', 'choice', array('choices' => array('French'=>'fr', 'English'=>'en',),'expanded' => true))
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
