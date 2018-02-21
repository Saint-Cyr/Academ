<?php

namespace AppBundle\Service;

use AppBundle\Entity\Section;
use AppBundle\Entity\Sequence;
use AppBundle\Entity\Student;

class BuildMarkTableLTBHandler
{
    //To store the entity manager
    private $em;
    private $utils;
    
    public function __construct($em, $utils) 
    {
        $this->em = $em;
        $this->utils = $utils;
    }
    
    public function generateMarkTableLTB(Section $section, Sequence $sequence)
    {
        //Get all the parameters like school name, year, ...
        $parameters = array();
        //Mark Tables
        $markTables = array();
        //Build the mark Table for each student (see algorithm in doc for more detailts)
        foreach ($section->getStudents() as $student){
            $markTables[] = $this->buildMarkTableOneStudentLTB($student, $sequence);
        }
        
        return array('parameters' => $parameters, 'mark_tables' => $markTables);
    }
    
    public function buildMarkTableOneStudentLTB(Student $student, Sequence $sequence)
    {
        //For each programs, build the columns
        $programs = $student->getSection()->getLevel()->getPrograms();
        //Prepare the variable that can content the markTable for one student
        $markTableOneStudent = array('student_name' => $student->getName());
        //For each program belonging to the section of the current student,
        //Build column one after another
        foreach ($programs as $prog){
            //get the computed mark from a service
            $computedMark = $this->utils->getComputedMark($student, $prog);
            //Get appreciation
            $appreciation = $this->utils->getAppreciation($computedMark);
            //Prepare the mark time coefficient
            $markCoef = ($computedMark * $prog->getCoefficient()->getValue());
            //Prepare teacher name Notice if null, then make sure to set it to unknown
            if(is_object($prog->getTeacher())){
                $teacherName = $prog->getTeacher()->getName();
            }else{
                $teacherName = 'Unknown';
            }
            
            //Build columns for the current program or current row (program Name, coef, mark/20, mark*Coef, ...)
            $row = array('program_name' => $prog->getName(),
                         'coefficient' => $prog->getCoefficient()->getValue(),
                         'mark' => $computedMark,
                         'mark_coefficient' => $markCoef,
                         'teacher' => $teacherName,
                         'appreciation' => $appreciation);
                         $rows[] = $row;
            
        }
        
        $markTableOneStudent['rows'] = $rows;
        
        return $markTableOneStudent;
    }
}
