<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class CoefficientAdmin extends AbstractAdmin
{
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            //->add('id')
            ->add('value')
            ->add('programs')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            //->add('id')
            ->add('value')
            ->add('programs')
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
        ->with('Coefficient Information', array('class' => 'col-md-4'))
            ->add('value')
            ->add('programs', null, array('attr' => array('style' => 'width:450px')))
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
    
    public function prePersist($project)
    {
        $this->preUpdate($project);
    }

    public function preUpdate($project)
    {
        $project->setPrograms($project->getPrograms());
    }
}
