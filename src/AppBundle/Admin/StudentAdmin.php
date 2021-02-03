<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\DoctrineORMAdminBundle\Filter\ModelAutocompleteFilter;
use Sonata\AdminBundle\Form\Type\ModelListType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class StudentAdmin extends AbstractAdmin
{
    
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('studentParent', ModelAutocompleteFilter::class, [], null, ['property' => 'name'])
            ->add('section', ModelAutocompleteFilter::class, [], null, ['property' => 'name'])     
            ->add('name')       
            ->add('sexe')       
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('name', null, array('editable' => true))
            ->add('firstName', null, array('editable' => true))
            ->add('phoneNumber', null, array('editable' => true))
            ->add('section')
            ->add('sexe')
            ->add('validated', null, ['editable' => true])
            ->add('studentParent')
            ->add('barcodeValue', null, array('editable' => true))
            ->add('address', null, ['editable' => true])
            ->add('leader', null, ['editable' => true])
            ->add('image')
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
        ->with('Student Information', array('class' => 'col-md-4'))
            ->add('name')
            ->add('firstName')
            ->add('sexe', ChoiceType::class, ['help' => 'Choose the student sexe please', 'choices' => ['Garçon' => 'male',
                                                            'Fille' => 'female'],
                                              'expanded' => true])
        ->end();
        $formMapper
        ->with('Contact', array('class' => 'col-md-4'))
            ->add('phoneNumber')
            ->add('address')
            ->add('email')
        ->end();

        $formMapper
        ->with('Academic status', array('class' => 'col-md-4'))
            ->add('section', null, ['attr' => ['style' => 'width: 500px'], 'label' => 'Current Section'])
            ->add('lastSchoolInstitution')
            //->add('leader')
            ->add('studentParent', ModelListType::class)
        ->end();
    }

    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
        ->with('Student Information', array('class' => 'col-md-4'))
            ->add('name')
            ->add('firstName')
            ->add('phoneNumber')
            ->add('address')
            ->add('email', 'email', ['required' => false])
        ->end();
        $showMapper
        ->with('Academic status', array('class' => 'col-md-4'))
            ->add('section', null, ['attr' => ['style' => 'width: 450px'], 'label' => 'Current Section'])
            ->add('lastSchoolInstitution')
            ->add('leader')
            ->add('studentParent', ModelListType::class)
        ->end();
    }
    
    public function getExportFields() {
        return array('#ID'=>'id', 'Name'=>'name', 'Bar Code' => 'barcodeValue');
    }
    
    public function getExportFormats() {
        parent::getExportFormats();
        return ['xls', 'csv'];
    }
}
