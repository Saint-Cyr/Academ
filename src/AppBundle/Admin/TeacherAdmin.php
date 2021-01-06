<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class TeacherAdmin extends AbstractAdmin
{
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
            ->add('programs')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('firstname', null, ['editable' => true])
            ->add('name', null, ['editable' => true])
            ->add('programs', null, ['editable' => true])
            ->add('sections', null, ['editable' => true])
            ->add('phoneNumber', null, ['editable' => true])
            ->add('adress', null, ['editable' => true])
            ->add('email', null, ['editable' => true])
            ->add('mainTeacher')
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
        ->with('Teacher Information', array('class' => 'col-md-4'))
            ->add('name', null, array('attr' => array('style' => 'width:450px')))
            ->add('firstName', null, array('attr' => array('style' => 'width:450px')))
            ->add('phoneNumber', null, array('attr' => array('style' => 'width:450px')))
            ->add('adress', null, array('attr' => array('style' => 'width:450px')))
            ->add('programs', null, array('attr' => array('style' => 'width:450px')))
        ->end()
        ;
    }

    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('name')
        ;
    }
    
    public function prePersist($project)
    {
        $this->preUpdate($project);
    }

    public function preUpdate($project)
    {
        $project->setPrograms($project->getPrograms());
    }
}
