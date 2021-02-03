<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\DoctrineORMAdminBundle\Filter\ModelAutocompleteFilter;
use Sonata\AdminBundle\Form\Type\ModelListType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class SectionAdmin extends AbstractAdmin
{
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
            ->add('level', ModelAutocompleteFilter::class, [], null, ['property' => 'name'])
            ->add('mainTeacher')
            ->add('studentCsvList', null, ['expanded' => true])
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id', null, [
            'header_style' => 'width: 2%; text-align: center',
            'row_align' => 'center'
        ])
            ->add('Mark Table', null, array('template' => '@App/Default/section_list.html.twig'))
            ->add('name', null, ['editable' => true])
            ->add('level', null, ['label_icon' => 'fa fa-book',
                                  'lable' => false])
            ->add('studentNumber')
            ->add('studentCsvList')
            ->add('studentLeaderInfo')
            //->add('evaluations')
            ->add('mainTeacher')
            ->add('level.programs', null, ['label' => 'Programs'])
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
