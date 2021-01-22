<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Sonata\DoctrineORMAdminBundle\Filter\ModelAutocompleteFilter;
use Sonata\DoctrineORMAdminBundle\Filter\ModelFilter;

class TeacherAdmin extends AbstractAdmin
{
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
            //->add('affectedPrograms')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('firstname', null, ['editable' => true])
            ->add('name', null, ['editable' => true])
            ->add('affectedPrograms')
            ->add('adress', null, ['editable' => true])
            ->add('email', null, ['editable' => true])
            ->add('mainTeacher')
            ->add('mainTeacherNumber')
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
            //->add('affectedPrograms', null, array('attr' => array('style' => 'width:500px')))
        ->end();
        $formMapper
            ->with('Affected Programs', array('class' => 'col-md-4'))
            ->add('affectedPrograms', null, ['attr' => ['style' => 'width: 500px']])
            ->add('clearAffectedPrograms', CheckboxType::class, ['label' => 'Unlink Affected Programs ?',
                                                                 'required' => false])
        ->end();
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

    public function preUpdate($teacher)
    {
        $affectedPrograms = $teacher->getAffectedPrograms();
        if($teacher->getClearAffectedPrograms()){
            foreach($affectedPrograms as $afp){
                $afp->setTeacher(null);        
            }
        }else{
            foreach($affectedPrograms as $afp){
                $afp->setTeacher($teacher);
            }
        }
    }
}
