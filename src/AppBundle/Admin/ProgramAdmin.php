<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class ProgramAdmin extends AbstractAdmin
{
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
            ->add('coefficient')
            ->add('field')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('name', null, array('editable' => true))
            ->add('coefficient', null, array('editable' => true))
            ->add('teacher')
            ->add('field')
                
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
            ->add('name')
            ->add('teacher')
            ->add('coefficient')
            ->add('level')
            ->add('field')
        ;
    }

    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('name')
        ;
    }
    
    public function prePersist($object) {
        parent::prePersist($object);
        //Set the name automatically in the case the user does not set it
        if(!$object->getName()){
            $object->setName($object->getField()->getName().' / '.$object->getLevel()->getName());
        }
        
    }
    
    public function preUpdate($object) {
        parent::prePersist($object);
        //Set the name automatically in the case the user does not set it
        if(!$object->getName()){
            $object->setName($object->getField()->getName().' / '.$object->getLevel()->getName());
        }
        
    }
}
