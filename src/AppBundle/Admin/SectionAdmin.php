<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\DoctrineORMAdminBundle\Filter\ModelAutocompleteFilter;
use Sonata\AdminBundle\Form\Type\ModelListType;

class SectionAdmin extends AbstractAdmin
{
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
            ->add('level', ModelAutocompleteFilter::class, [], null, ['property' => 'name'])
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('Mark Table', null, array('template' => '@App/Default/section_list.html.twig'))
            ->add('name', null, ['editable' => true])
            ->add('level')
            ->add('studentNumber')
            ->add('studentCsvList')
            ->add('studentLeader')
            ->add('evaluations')
            ->add('mainTeacher')
            ->add('level.programs')
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
        ->with('Section Information', array('class' => 'col-md-4'))
            ->add('name', null, array('attr' => array('style' => 'width: 450px')))
            ->add('level', null, array('attr' => array('style' => 'width: 450px')))
        ->end();
        $formMapper
        ->with('Student (.xls)', array('class' => 'col-md-4'))
            //->add('collectedImage')
            ->add('file', 'file', array('required' => false))
        ->end();
        $formMapper
        ->with('Main teacher Information', array('class' => 'col-md-4'))
            ->add('mainTeacher', ModelListType::class)
        ->end();
    }

    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('name')
        ;
    }

    public function prePersist($image)
    {
        $this->manageFileUpload($image);
    }

    public function preUpdate($image)
    {
        $this->manageFileUpload($image);
    }

    private function manageFileUpload($image)
    {
        if ($image->getFile()) {
            $image->refreshUpdated();
        }
    }
}
