<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\DoctrineORMAdminBundle\Filter\ModelAutocompleteFilter;

class ProgramAdmin extends AbstractAdmin
{
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
            ->add('coefficient', ModelAutocompleteFilter::class, [], null, ['property' => 'value'])
            ->add('field', ModelAutocompleteFilter::class, [], null, ['property' => 'name'])
            ->add('level', ModelAutocompleteFilter::class, [], null, ['property' => 'name'])
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('name', null, array('editable' => true))
            ->add('level')
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
        ->with('Program Information', array('class' => 'col-md-4'))
            ->add('name')
            ->add('coefficient', null, ['attr' => ['style' => 'width:500px'], 'required' => true])
            ->add('level', null, array('attr' => array('style' => 'width:500px')))
            ->add('field', null, array('attr' => array('style' => 'width: 500px')))
            ->add('affectedPrograms', null, array('attr' => array('style' => 'width: 500px')))
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
