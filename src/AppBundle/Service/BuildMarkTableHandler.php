<?php

namespace AppBundle\Service;

use AppBundle\Entity\Section;
use AppBundle\Entity\Sequence;
use AppBundle\Entity\Student;
use AppBundle\Entity\Setting;

class BuildMarkTableHandler
{
    //To store the entity manager
    private $em;
    private $utils;
    
    public function __construct($em, $utilsSTD) 
    {
        $this->em = $em;
        $this->utils = $utilsSTD;
    }
    
    public function generateMarkTable(Section $section, $setting)
    {
        //Get the current sequence
        $sequence = $setting->getSequence();
        //Get all the parameters that are common to each marktable like school name, year, ...
        $parameters['section_name'] = $section->getName();
        $parameters['main_teacher'] = $section->getMainTeacher()->getTeacher()->getName();
        $parameters['student_number'] = $section->getStudentNumber();
        $parameters['total_coefficient'] = $section->getTotalCoefficient();
        $parameters['sequence'] = $sequence->getSequenceOrder();
        $parameters['council_date'] = $setting->getCouncilDate();
        
        //Mark Tables
        $markTables = array();
        //Build the mark Table for each student (see algorithm in doc for more detailts)
        foreach ($section->getStudents() as $student){
            $markTables[] = $this->buildMarkTableOneStudent($student, $sequence);
        }
    
        return array('parameters' => $parameters, 'mark_tables' => $markTables);
    }
    
    public function buildMarkTableOneStudent(Student $student, Sequence $sequence)
    {
        //Anyway we'll need the setting
        $setting = $this->em->getRepository('AppBundle:Setting')->findOneBy(array('name' => 'setting'));
        //We will need also all the affectedProgram
        $affectedPrograms = $student->getSection()->getAffectedPrograms();
        $programs = $student->getSection()->getLevel()->getPrograms();
        //Prepare the variable that can content the markTable for one student
        $param['student_name'] = $student->getName();
        //Make sure the current student have a parent before we call the getParent() methode
        if($student->getStudentParent()){
            $markTableOneStudent = array('student_parent' => $student->getStudentParent()->getName());    
        }
        //Prepare the variable for totalMarkCoefficient
        $totalMarkCoefficient = null;
        //For each affected program belonging to the section of the current student,
        //Build column one after another
        foreach ($affectedPrograms as $affectedProg){
            //get the computed mark (for Devoir only) from a service
            //Notice that only mark for the right sequence (the activated one) must be used
            $computedMark = $student->getMarksByAffectedProgramAndSequence($affectedProg, $sequence);
            //$computedMark = number_format($this->utils->getComputedMark($student, $prog, false, $sequence), 2);
            //Get mark for Composition
            $markForComposition = $this->utils->getMarkForComposition($student, $prog, $sequence);
            //Get the average: $composition + $computedMark / 3 according to the rule in CAR
            $average = number_format(($computedMark + $markForComposition)/3, 2);
            //Get appreciation
            $appreciation = $this->utils->getAppreciation($average);
            //Prepare the mark time coefficient
            $markCoef = ($average * $prog->getCoefficient()->getValue());
            $markCoef = number_format($markCoef, 2);
            //Prepare total mark Coefficient
            $totalMarkCoefficient = number_format(($totalMarkCoefficient + $markCoef), 2);
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
                         'appreciation' => $appreciation,
                         'mark_composition' => $markForComposition,
                         'average' => $average);
                         $rows[] = $row;
        }
        
        //Set the global appreciation
        $totalCoefficient = $student->getSection()->getTotalCoefficient();
        $globalAppreciation = $this->utils->getGlobalAppreciation($totalMarkCoefficient / $totalCoefficient);
        $param['total_coefficient'] = $totalCoefficient;
        $param['global_appreciation'] = $globalAppreciation;
        $param['total_mark_coefficient'] = number_format($totalMarkCoefficient, 2);
        //round total_mark to 2 decimals
        $param['total_mark'] = number_format($totalMarkCoefficient / $student->getSection()->getTotalCoefficient(), 2);
        //Prepare the template to display all the marks by sequence according to the current sequence
        //in the case of seggragation between 1st, 2nd or 3rd sequence mark
        //$param['marks_by_sequence'] = $this->buildMarksBySequenceTemplate($sequence, $student);
        //1rs trimester
        if($sequence->getSequenceOrder() == 1){
            $markSequence1 = $this->getTotalMarkBySequence($sequence, $student);
            $param['marks_by_sequence'] = array('first' => $markSequence1,
                                                'two' => 'N/A',
                                                'three' => 'N/A',
                                                'Gen' => 'N/A');
        //2nd Trimester
        }elseif($sequence->getSequenceOrder() == 2){
            //In case of 3 sequences (trimester)
            if($setting->getDefinedYearlySequenceNumber() == 3){
                //Get the marktable for sequence 1 & 2
                $seq1 = $this->em->getRepository('AppBundle:Sequence')->findOneBy(array('sequenceOrder' => 1));
                $seq2 = $this->em->getRepository('AppBundle:Sequence')->findOneBy(array('sequenceOrder' => 2));
                $markSequence1 = $this->getTotalMarkBySequence($seq1, $student);
                $markSequence2 = $this->getTotalMarkBySequence($seq2, $student);
                $param['marks_by_sequence'] = array('first' => $markSequence1,
                                                    'two' => $markSequence2,
                                                    'three' => 'N/A',
                                                    'Gen' => 'N/A');
                //In case of 2 sequence (semester)
            }else{
                //Get the marktable for sequence 1 & 2
                //Close the academic year on this mark Table thus don't forget to compute and display (M1+M2)/2
                $seq1 = $this->em->getRepository('AppBundle:Sequence')->findOneBy(array('sequenceOrder' => 1));
                $seq2 = $this->em->getRepository('AppBundle:Sequence')->findOneBy(array('sequenceOrder' => 2));
                $markSequence1 = $this->getTotalMarkBySequence($seq1, $student);
                $markSequence2 = $this->getTotalMarkBySequence($seq2, $student);
                $param['marks_by_sequence'] = array('first' => $markSequence1,
                                                    'two' => $markSequence2,
                                                    'three' => 'N/A',
                                                    'Gen' => ($markSequence1+$markSequence2)/2);
                
            }
        //3rd Trimester
        }else{
            //Get the marktable for sequence 1 & 2
                $seq1 = $this->em->getRepository('AppBundle:Sequence')->findOneBy(array('sequenceOrder' => 1));
                $seq2 = $this->em->getRepository('AppBundle:Sequence')->findOneBy(array('sequenceOrder' => 2));
                $seq3 = $this->em->getRepository('AppBundle:Sequence')->findOneBy(array('sequenceOrder' => 3));
                $markSequence1 = $this->getTotalMarkBySequence($seq1, $student);
                $markSequence2 = $this->getTotalMarkBySequence($seq2, $student);
                $markSequence3 = $this->getTotalMarkBySequence($seq3, $student);
                $param['marks_by_sequence'] = array('first' => $markSequence1,
                                                    'two' => $markSequence2,
                                                    'three' => $markSequence3,
                                                    'Gen' => ($markSequence1+$markSequence2+$markSequence3)/3);
        }
        //Those are the parameters that are related to a particular mark table (exple: Student Name, totalMarkCoef...)
        $markTableOneStudent['param'] = $param;
        
        $markTableOneStudent['rows'] = $rows;
        
        return $markTableOneStudent;
    }
    
    
    public function getTotalMarkBySequence(Sequence $sequence, Student $student)
    {
        $programs = $student->getSection()->getLevel()->getPrograms();
        //Prepare the variable that can content the markTable for one student
        $param['student_name'] = $student->getName();
        //Make sure the current student have a parent before we call the getParent() methode
        if($student->getStudentParent()){
            $markTableOneStudent = array('student_parent' => $student->getStudentParent()->getName());    
        }
        
        //Prepare the variable for totalMarkCoefficient
        $totalMarkCoefficient = null;
        //For each program belonging to the section of the current student,
        //Build column one after another
        foreach ($programs as $prog){
            //get the computed mark (for Devoir only) from a service
            //Notice that only mark for the right sequence (the activated one) must be used
            $computedMark = $student->getDevoirMarksBySequenceByProgram($sequence, $prog);
            //$computedMark = number_format($this->utils->getComputedMark($student, $prog, false, $sequence), 2);
            //Get mark for Composition
            $markForComposition = $this->utils->getMarkForComposition($student, $prog, $sequence);
            //Get the average: $composition + $computedMark / 3 according to the rule in CAR
            $average = number_format(($computedMark + $markForComposition)/3, 2);
            //Get appreciation
            $appreciation = $this->utils->getAppreciation($average);
            //Prepare the mark time coefficient
            $markCoef = ($average * $prog->getCoefficient()->getValue());
            $markCoef = number_format($markCoef, 2);
            //Prepare total mark Coefficient
            $totalMarkCoefficient = number_format(($totalMarkCoefficient + $markCoef), 2);
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
                         'appreciation' => $appreciation,
                         'mark_composition' => $markForComposition,
                         'average' => $average);
                         $rows[] = $row;
        }
        
        //Set the global appreciation
        $totalCoefficient = $student->getSection()->getTotalCoefficient();
        $globalAppreciation = $this->utils->getGlobalAppreciation($totalMarkCoefficient / $totalCoefficient);
        $param['total_coefficient'] = $totalCoefficient;
        $param['global_appreciation'] = $globalAppreciation;
        $param['total_mark_coefficient'] = number_format($totalMarkCoefficient, 2);
        //round total_mark to 2 decimals
        $param['total_mark'] = number_format($totalMarkCoefficient / $student->getSection()->getTotalCoefficient(), 2);
        
        return $param['total_mark'];
    }
}
