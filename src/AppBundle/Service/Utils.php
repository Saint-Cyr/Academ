<?php

namespace AppBundle\Service;

use AppBundle\Entity\Student;
use AppBundle\Entity\Program;

class Utils
{
    //To store the entity manager
    private $em;
    
    public function __construct($em) 
    {
        $this->em = $em;
    }
    
    /*
     * This methode suppose to compute all mark for a given student based on
     * the current prog ($prog) and give back the avarage value
     * Exple: if the student have two mark in Math 1ere C such as 12.5 & 7.5
     * then the avarage will be (12.5+7.5)/2
     */
    public function getComputedMark(Student $student, Program $prog)
    {
        //Get the mark number
        $markNb = 0;
        //Prepare the variable that will hold all the selected mark.(the one belongs to $prog)
        $selectedMark = 0;
        //Select only marks that belong to $prog
        foreach ($student->getMarks() as $mark){
            //if this mark belongs to $prog then select it
            if($mark->getEvaluation()->getProgram()->getId() == $prog->getId()){
                //Make sure to count the number of evaluation for the current program
                $markNb = $markNb + 1;
                $selectedMark = $selectedMark + $mark->getValue();
            }
        }
        //return the average value of the marks for the program $prog
        return ($selectedMark / $markNb);
    }
    
    public function getAppreciation($mark)
    {
        if($mark >= 0 && $mark < 5){
            //Null
            return 'Null';
        }elseif($mark >= 5 && $mark < 7){
            //Tres Faible
            return 'Tres-Faible';
        }elseif($mark >= 7 && $mark < 8){
            //Faible
            return 'Faible';
        }elseif($mark >= 8 && $mark < 10){
            //Insuffisant
            return 'Insuffisant';
        }elseif($mark >= 10 && $mark < 11){
            //Moyenne
            return 'Moyenne';
        }elseif($mark >= 11 && $mark < 12){
            //Passable
            return 'Passable';
        }elseif($mark >= 12 && $mark < 14){
            //Assez-Bien
            return 'Assez-Bien';
        }elseif($mark >= 14 && $mark < 15){
            //Bien
            return 'Bien';
        }elseif($mark >= 15 && $mark < 19){
            //Tres Bien
            return 'Tres-Bien';
        }elseif($mark >= 19 && $mark < 21){
            //Excellent
            return 'Excellent';
        }
        
        return 'Unknown';
    }
}
